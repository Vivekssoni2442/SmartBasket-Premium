<?php

namespace App\Services;

use App\Models\OrderCancellationRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SellerCancellationSms
{
    public function send(OrderCancellationRequest $cancellation): bool
    {
        $seller = $cancellation->seller;
        $accountSid = trim((string) config('services.twilio.sid'));
        $authToken = trim((string) config('services.twilio.token'));
        $from = trim((string) config('services.twilio.from'));
        $messagingServiceSid = trim((string) config('services.twilio.messaging_service_sid'));

        if (! $seller || ! $accountSid || ! $authToken || (! $from && ! $messagingServiceSid)) {
            Log::notice('Order cancellation SMS skipped because Twilio is not configured.', [
                'cancellation_id' => $cancellation->id,
                'seller_id' => $cancellation->seller_id,
            ]);

            return false;
        }

        $to = $this->toE164((string) ($seller->mobile_number ?: $seller->payment_mobile_number ?: $seller->phone));
        if (! $to) {
            Log::notice('Order cancellation SMS skipped because the seller has no valid mobile number.', [
                'cancellation_id' => $cancellation->id,
                'seller_id' => $seller->id,
            ]);

            return false;
        }

        $order = $cancellation->order;
        $amount = number_format((float) $cancellation->refund_amount, 2);
        $body = $cancellation->status === OrderCancellationRequest::STATUS_REFUND_PENDING
            ? "Smart Basket: Order #{$order->id} was cancelled. Refund INR {$amount} is pending. View the customer's secure refund details: " . route('seller.order-cancellations.index')
            : "Smart Basket: Order #{$order->id} was cancelled. View the request: " . route('seller.order-cancellations.index');

        $payload = ['To' => $to, 'Body' => $body];
        if ($messagingServiceSid) {
            $payload['MessagingServiceSid'] = $messagingServiceSid;
        } else {
            $payload['From'] = $from;
        }

        try {
            Http::asForm()
                ->withBasicAuth($accountSid, $authToken)
                ->timeout(12)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", $payload)
                ->throw();

            return true;
        } catch (Throwable $exception) {
            Log::warning('Order cancellation SMS could not be sent.', [
                'cancellation_id' => $cancellation->id,
                'seller_id' => $seller->id,
                'exception' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    private function toE164(string $mobile): ?string
    {
        $digits = preg_replace('/\D+/', '', $mobile) ?: '';
        if (strlen($digits) === 10) {
            $digits = '91' . $digits;
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = '91' . substr($digits, 1);
        }

        return strlen($digits) >= 11 && strlen($digits) <= 15 ? '+' . $digits : null;
    }
}
