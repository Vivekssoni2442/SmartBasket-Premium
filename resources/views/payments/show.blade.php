<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Status | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <style>
        body { background: linear-gradient(135deg, #020617, #1e3a8a); color: white; min-height: 100vh; }
        .checkout-card { max-width: 720px; margin: 40px auto; background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); border-radius: 1.3rem; padding: 2rem; }
        .payment-box { background: rgba(255,255,255,0.08); border-radius: 1rem; padding: 1rem; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="checkout-card">
        <h1 class="fw-bold mb-3">Payment Verification</h1>

        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        <div id="paymentMessage" class="alert {{ $payment->status === 'failed' || $payment->status === 'cancelled' ? 'alert-danger' : 'alert-info' }}">
            @if($payment->status === 'paid')
                Payment successful. Redirecting to order success...
            @elseif($payment->status === 'failed')
                Payment Failed. {{ $payment->failure_reason }}
            @elseif($payment->status === 'cancelled')
                Payment Cancelled. You can retry payment or go back to checkout.
            @elseif(! $gatewayReady)
                Payment Pending. Online payment gateway is not configured yet.
            @else
                Payment Pending. Start payment to confirm your order.
            @endif
        </div>

        <div class="payment-box mb-4">
            <div class="d-flex justify-content-between py-2">
                <span>Payment Method</span>
                <strong>{{ $payment->payment_method }}</strong>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span>Amount</span>
                <strong>&#8377;{{ number_format((float) $payment->amount, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span>Status</span>
                <strong id="paymentStatus">{{ ucfirst($payment->status) }}</strong>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @if($gatewayReady)
                <button type="button" class="btn btn-warning fw-bold" id="payNowBtn">Pay Now</button>
            @else
                <button type="button" class="btn btn-warning fw-bold" disabled>Payment Pending</button>
            @endif
            <form method="POST" action="{{ route('payments.cancel', $payment) }}">
                @csrf
                <button type="submit" class="btn btn-outline-light">Back to Checkout</button>
            </form>
            <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-info">Retry Payment</a>
        </div>
    </div>
</div>

@if($gatewayReady)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(() => {
    const button = document.getElementById('payNowBtn');
    const message = document.getElementById('paymentMessage');
    const status = document.getElementById('paymentStatus');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    let processing = false;

    const setMessage = (text, type) => {
        message.textContent = text;
        message.className = 'alert alert-' + type;
    };

    const verifyPayment = async (response) => {
        const res = await fetch(@json(route('payments.verify', $payment)), {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(response)
        });
        const data = await res.json();
        if (!res.ok || !data.success) {
            throw new Error(data.message || 'Payment verification failed');
        }
        return data;
    };

    button.addEventListener('click', () => {
        if (processing) return;
        processing = true;
        button.disabled = true;
        button.textContent = 'Processing Payment...';
        setMessage('Processing Payment...', 'info');
        status.textContent = 'Processing';

        const checkout = new Razorpay({
            key: @json($razorpayKey),
            amount: @json($payment->amount_paise),
            currency: @json($payment->currency),
            name: 'Smart Basket',
            description: 'Order payment',
            order_id: @json($payment->gateway_order_id),
            prefill: {
                name: @json($payment->customer_details['name'] ?? ''),
                contact: @json($payment->customer_details['mobile'] ?? '')
            },
            handler: async (response) => {
                try {
                    const data = await verifyPayment(response);
                    setMessage('Payment Successful. Order Confirmed.', 'success');
                    status.textContent = 'Paid';
                    window.location.href = data.redirect;
                } catch (error) {
                    setMessage(error.message, 'danger');
                    status.textContent = 'Failed';
                    processing = false;
                    button.disabled = false;
                    button.textContent = 'Retry Payment';
                }
            },
            modal: {
                ondismiss: () => {
                    setMessage('Payment Cancelled. Your order was not confirmed.', 'warning');
                    status.textContent = 'Cancelled';
                    processing = false;
                    button.disabled = false;
                    button.textContent = 'Retry Payment';
                }
            }
        });

        checkout.on('payment.failed', (response) => {
            setMessage(response.error && response.error.description ? response.error.description : 'Payment Failed', 'danger');
            status.textContent = 'Failed';
            processing = false;
            button.disabled = false;
            button.textContent = 'Retry Payment';
        });

        checkout.open();
    });
})();
</script>
@endif
</body>
</html>
