<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\OrderInvoiceService;
use App\Services\WhatsAppCloudApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendOrderInvoiceWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public int $orderId)
    {
    }

    public function backoff(): array
    {
        return [30, 120];
    }

    public function handle(OrderInvoiceService $invoices, WhatsAppCloudApi $whatsapp): void
    {
        $order = Order::with('seller')->findOrFail($this->orderId);
        if (! $order->whatsapp_invoice_opt_in || ! $order->seller?->whatsapp_invoice_enabled) {
            return;
        }

        if ($order->whatsapp_invoice_status === 'sent') {
            return;
        }

        $order->forceFill(['whatsapp_invoice_status' => 'sending', 'whatsapp_invoice_error' => null])->save();

        try {
            $pdf = $invoices->pdf($order);
            $messageId = $whatsapp->sendOrderInvoice($order, $pdf);
            $order->forceFill([
                'whatsapp_invoice_status' => 'sent',
                'whatsapp_invoice_message_id' => $messageId,
                'whatsapp_invoice_sent_at' => now(),
                'whatsapp_invoice_error' => null,
            ])->save();
        } catch (Throwable $exception) {
            $order->forceFill([
                'whatsapp_invoice_status' => 'queued',
                'whatsapp_invoice_error' => mb_substr($exception->getMessage(), 0, 2000),
            ])->save();
            Log::warning('Order invoice WhatsApp delivery failed; queue retry scheduled.', [
                'order_id' => $order->id,
                'seller_id' => $order->seller_id,
                'attempt' => $this->attempts(),
                'message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    public function failed(?Throwable $exception): void
    {
        Order::whereKey($this->orderId)->update([
            'whatsapp_invoice_status' => 'failed',
            'whatsapp_invoice_error' => mb_substr($exception?->getMessage() ?: 'WhatsApp delivery failed.', 0, 2000),
        ]);

        Log::error('Order invoice WhatsApp delivery failed after queue retries.', [
            'order_id' => $this->orderId,
            'message' => $exception?->getMessage(),
        ]);
    }
}
