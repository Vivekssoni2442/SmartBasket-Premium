<?php

namespace App\Contracts;

use App\Models\PaymentTransaction;

interface PaymentGatewayInterface
{
    public function isConfigured(): bool;

    public function publicKey(): ?string;

    /** @return array{success: bool, gateway_order_id?: string, message?: string} */
    public function createOrder(PaymentTransaction $transaction): array;

    public function verifySignature(string $gatewayOrderId, string $gatewayPaymentId, string $signature): bool;

    /** @return array{success: bool, status?: string, amount?: int, currency?: string, order_id?: string, message?: string} */
    public function fetchPayment(string $gatewayPaymentId): array;

    public function verifyWebhookSignature(string $payload, string $signature): bool;

    /** @return array{success: bool, gateway_refund_id?: string, status?: string, message?: string} */
    public function createRefund(PaymentTransaction $transaction, string $amount): array;
}
