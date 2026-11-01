<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoiceService
{
    public function data(Order $order): array
    {
        $order->loadMissing(['seller', 'user']);
        $productIds = collect($order->items ?? [])->pluck('product_id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $payment = PaymentTransaction::query()
            ->where('user_id', $order->user_id)
            ->whereJsonContains('order_ids', (int) $order->id)
            ->latest('id')
            ->first();

        $transactionId = null;
        if ($payment?->gateway === 'seller_upi') {
            $transactionId = $payment->request_metadata['upi_references'][(string) $order->seller_id] ?? null;
        }
        $transactionId ??= $payment?->gateway_transaction_id ?: $payment?->gateway_payment_id;
        if (! $transactionId && $order->isCashOnDelivery()) {
            $transactionId = 'COD-' . $order->id;
        }

        return [
            'order' => $order,
            'seller' => $order->seller,
            'products' => $products,
            'payment' => $payment,
            'paymentStatus' => $order->isCashOnDelivery() ? 'Cash on Delivery' : $order->payment_status_label,
            'paymentId' => $transactionId,
            'transactionId' => $transactionId,
            'gatewayOrderId' => $payment?->gateway_order_id,
            'paymentDate' => $payment?->verified_at ?? $order->created_at,
            'invoiceNumber' => trim((string) ($order->seller?->preference('invoice_prefix', 'SB-') ?? 'SB-')) . $order->id,
        ];
    }

    public function pdf(Order $order): string
    {
        return Pdf::loadView('orders.receipt', $this->data($order))
            ->setPaper('a4', 'portrait')
            ->output();
    }
}
