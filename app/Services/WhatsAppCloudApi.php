<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsAppCloudApi
{
    public function sendOrderInvoice(Order $order, string $pdfBytes): string
    {
        $seller = $order->seller;
        if (! $seller?->whatsapp_invoice_enabled
            || blank($seller->whatsapp_phone_number_id)
            || blank($seller->whatsapp_access_token)
            || blank($seller->whatsapp_invoice_template)) {
            throw new RuntimeException('Seller WhatsApp Business API settings are incomplete or disabled.');
        }

        $recipient = $this->normalizePhone($order->mobile);
        if (! $recipient) {
            throw new RuntimeException("The customer's checkout mobile number is not a valid WhatsApp destination.");
        }

        $version = trim((string) config('services.whatsapp.graph_api_version'));
        if (! preg_match('/^v\d+\.\d+$/', $version)) {
            throw new RuntimeException('Set WHATSAPP_GRAPH_API_VERSION to a supported Meta Graph API version.');
        }

        $baseUrl = 'https://graph.facebook.com/' . $version . '/' . rawurlencode($seller->whatsapp_phone_number_id);
        $token = $seller->whatsapp_access_token;
        $filename = 'Smart-Basket-Invoice-' . $order->id . '.pdf';

        $upload = Http::withToken($token)
            ->timeout(35)
            ->attach('file', $pdfBytes, $filename, ['Content-Type' => 'application/pdf'])
            ->post($baseUrl . '/media', [
                'messaging_product' => 'whatsapp',
                'type' => 'application/pdf',
            ]);

        if (! $upload->successful() || ! filled($upload->json('id'))) {
            throw new RuntimeException('WhatsApp could not upload the PDF invoice: ' . $this->apiError($upload->json()));
        }

        $paymentText = $order->isCashOnDelivery()
            ? 'Cash on Delivery'
            : ($this->paymentReference($order) ?: (string) $order->payment_status_label);
        $response = Http::withToken($token)
            ->acceptJson()
            ->timeout(35)
            ->post($baseUrl . '/messages', [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $recipient,
                'type' => 'template',
                'template' => [
                    'name' => $seller->whatsapp_invoice_template,
                    'language' => ['code' => $seller->whatsapp_template_language ?: 'en_US'],
                    'components' => [
                        [
                            'type' => 'header',
                            'parameters' => [[
                                'type' => 'document',
                                'document' => [
                                    'id' => $upload->json('id'),
                                    'filename' => $filename,
                                ],
                            ]],
                        ],
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => (string) $order->id],
                                ['type' => 'text', 'text' => mb_substr((string) $order->name, 0, 80)],
                                ['type' => 'text', 'text' => 'INR ' . number_format((float) ($order->amount ?? $order->total), 2)],
                                ['type' => 'text', 'text' => mb_substr($paymentText, 0, 120)],
                            ],
                        ],
                    ],
                ],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('WhatsApp rejected the invoice message: ' . $this->apiError($response->json()));
        }

        $messageId = $response->json('messages.0.id');
        if (! is_string($messageId) || $messageId === '') {
            throw new RuntimeException('WhatsApp did not return a message ID for the invoice.');
        }

        return $messageId;
    }

    private function paymentReference(Order $order): ?string
    {
        $transaction = PaymentTransaction::query()
            ->where('user_id', $order->user_id)
            ->whereJsonContains('order_ids', (int) $order->id)
            ->latest('id')
            ->first();

        if ($transaction?->gateway === 'seller_upi') {
            $reference = $transaction->request_metadata['upi_references'][(string) $order->seller_id] ?? null;
            if (filled($reference)) {
                return (string) $reference;
            }
        }

        return $transaction?->gateway_transaction_id ?: $transaction?->gateway_payment_id;
    }

    private function normalizePhone(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if (strlen($digits) === 10) {
            $digits = '91' . $digits;
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = '91' . substr($digits, 1);
        }

        return strlen($digits) >= 11 && strlen($digits) <= 15 ? $digits : null;
    }

    private function apiError(?array $response): string
    {
        $message = data_get($response, 'error.message');

        return is_string($message) && $message !== '' ? mb_substr($message, 0, 450) : 'Unknown Meta API error.';
    }
}
