<style>
    .oc-page{width:100%;max-width:none;margin:0;padding:clamp(15px,2.5vw,30px);color:#17243a}
    .oc-hero{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:19px;padding:clamp(21px,3vw,32px);border-radius:24px;background:linear-gradient(120deg,#17254a,#344f9b 68%,#7657bf);color:#fff;box-shadow:0 18px 42px #263c7829}
    .oc-hero h1{margin:0;font-size:clamp(1.45rem,3vw,2rem);font-weight:950;letter-spacing:-.04em}.oc-hero p{margin:7px 0 0;color:#dbe6ff}.oc-count{display:grid;place-items:center;min-width:58px;height:58px;padding:0 13px;border:1px solid #ffffff4d;border-radius:18px;background:#ffffff1f;font-size:1.2rem;font-weight:900}
    .oc-alert{margin-bottom:15px;padding:13px 16px;border:1px solid #bbf7d0;border-radius:14px;background:#f0fdf4;color:#166534;font-weight:750}.oc-list{display:grid;gap:15px}.oc-card{overflow:hidden;border:1px solid #dce5f1;border-radius:20px;background:#fff;box-shadow:0 10px 30px #1523420d}.oc-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;padding:18px 20px;border-bottom:1px solid #edf1f7}.oc-card-head h2{margin:0;font-size:1.02rem;font-weight:900}.oc-muted{color:#68758c;font-size:.84rem}.oc-badge{display:inline-flex;align-items:center;gap:7px;padding:7px 11px;border-radius:99px;background:#fff5df;color:#9a5b05;font-size:.72rem;font-weight:900;white-space:nowrap}.oc-badge.refunded{background:#e9f9f0;color:#087d50}.oc-badge.no_refund{background:#eef2f7;color:#536174}.oc-body{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(280px,.9fr);gap:18px;padding:18px 20px}.oc-products{display:grid;gap:10px}.oc-product{display:grid;grid-template-columns:58px 1fr auto;gap:12px;align-items:center;padding:10px;border:1px solid #edf1f6;border-radius:14px}.oc-product img{width:58px;height:58px;object-fit:cover;border-radius:12px;background:#f0f3f8}.oc-product strong{display:block;font-size:.88rem}.oc-product small{color:#6b778c}.oc-product-price{font-weight:900;white-space:nowrap}.oc-details{padding:16px;border:1px solid #e5ebf4;border-radius:15px;background:#f9fbfe}.oc-details h3{margin:0 0 12px;font-size:.96rem;font-weight:900}.oc-data{display:grid;grid-template-columns:145px 1fr;gap:7px 12px;margin:0;font-size:.83rem}.oc-data dt{color:#65728a;font-weight:650}.oc-data dd{margin:0;color:#17243a;font-weight:800;overflow-wrap:anywhere}.oc-qr-wrap{display:flex;align-items:center;gap:14px;margin-top:14px;padding:12px;border:1px solid #dce6fb;border-radius:14px;background:#f5f8ff}.oc-qr{display:grid;place-items:center;width:132px;height:132px;flex:0 0 132px;padding:6px;border:1px solid #e3eaf5;border-radius:11px;background:#fff}.oc-qr img{max-width:100%;height:auto}.oc-qr-note{color:#5b6880;font-size:.76rem;line-height:1.5}.oc-qr-note strong{display:block;margin-bottom:4px;color:#1b2a48;font-size:.85rem}.oc-bank-note{margin-top:12px;padding:10px 12px;border-radius:12px;background:#fff7e8;color:#815008;font-size:.78rem;line-height:1.5}.oc-actions{display:flex;flex-wrap:wrap;gap:10px;align-items:end;margin-top:15px}.oc-actions .form-control{max-width:220px;min-height:42px;border-radius:11px}.oc-done{min-height:42px;padding:0 14px;border:0;border-radius:11px;background:linear-gradient(120deg,#087d5b,#16a36a);color:#fff;font-size:.8rem;font-weight:900}.oc-empty{padding:46px 18px;border:1px dashed #cbd5e1;border-radius:20px;background:#fff;text-align:center}.oc-empty i{color:#16a36a;font-size:2rem}.oc-empty h2{margin:12px 0 4px;font-size:1.1rem;font-weight:900}.oc-empty p{margin:0;color:#66748a}.oc-pagination{margin-top:18px}
    @media(max-width:800px){.oc-body{grid-template-columns:1fr}}@media(max-width:550px){.oc-page{padding:13px}.oc-hero{padding:20px;border-radius:19px}.oc-card-head,.oc-body{padding:14px}.oc-data{grid-template-columns:1fr;gap:2px}.oc-data dd{margin-bottom:7px}.oc-qr-wrap{align-items:flex-start}.oc-qr{width:112px;height:112px;flex-basis:112px}.oc-actions>*{width:100%;max-width:none!important}.oc-product{grid-template-columns:50px 1fr}.oc-product img{width:50px;height:50px}.oc-product-price{grid-column:2}}
</style>

<section class="oc-page">
    <header class="oc-hero">
        <div><h1><i class="fa-solid fa-arrow-right-arrow-left me-2"></i>Cancellations</h1><p>Review cancelled orders and complete pending customer refunds.</p></div>
        <span class="oc-count" aria-label="{{ $refundCount }} pending refunds">{{ $refundCount }}</span>
    </header>

    @if(session('success'))<div class="oc-alert" role="status"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>@endif

    @if($cancellations->isEmpty())
        <section class="oc-empty"><i class="fa-solid fa-circle-check" aria-hidden="true"></i><h2>No cancellations</h2><p>Customer cancellations will appear here.</p></section>
    @else
        <div class="oc-list">
            @foreach($cancellations as $cancellation)
                @php
                    $order = $cancellation->order;
                    $statusClass = $cancellation->status === 'refunded' ? 'refunded' : ($cancellation->status === 'no_refund' ? 'no_refund' : '');
                    $customerName = $order?->name ?: $cancellation->customer?->name ?: 'Customer';
                    $upiUri = $cancellation->refund_method === 'upi' && $cancellation->upi_id
                        ? 'upi://pay?' . http_build_query([
                            'pa' => $cancellation->upi_id,
                            'pn' => $customerName,
                            'am' => number_format((float) $cancellation->refund_amount, 2, '.', ''),
                            'cu' => 'INR',
                            'tn' => 'Refund Order ' . $order?->id,
                        ], '', '&', PHP_QUERY_RFC3986)
                        : null;
                @endphp
                <article class="oc-card">
                    <header class="oc-card-head">
                        <div><h2>Order #{{ $order?->id }} · {{ $customerName }}</h2><span class="oc-muted">Cancelled {{ $order?->cancelled_at?->format('d M Y, h:i A') ?: $cancellation->created_at?->format('d M Y, h:i A') }} · {{ $order?->mobile }}</span></div>
                        <span class="oc-badge {{ $statusClass }}"><i class="fa-solid {{ $cancellation->status === 'refunded' ? 'fa-circle-check' : ($cancellation->status === 'no_refund' ? 'fa-minus-circle' : 'fa-clock') }}"></i>{{ $cancellation->status === 'refund_pending' ? 'Refund pending' : ($cancellation->status === 'refunded' ? 'Refund marked sent' : 'No refund due') }}</span>
                    </header>
                    <div class="oc-body">
                        <div>
                            <div class="oc-products">
                                @foreach($order?->items ?? [] as $item)
                                    @php($product = $cancellationProducts->get((int) ($item['product_id'] ?? 0)))
                                    <div class="oc-product">
                                        @if($product?->image)<img src="{{ asset('products/' . $product->image) }}" alt="">@else<div class="d-grid place-items-center rounded-3 bg-light" style="width:58px;height:58px"><i class="fa-solid fa-box text-secondary"></i></div>@endif
                                        <div><strong>{{ $item['name'] ?? $product?->name ?? 'Product' }}</strong><small>Qty {{ (int) ($item['quantity'] ?? 1) }}</small></div>
                                        <span class="oc-product-price">₹{{ number_format((float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1), 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between mt-3 px-1"><span class="oc-muted">Cancellation reason</span><strong>{{ $cancellation->reason ?: 'Not provided' }}</strong></div>
                        </div>

                        <section class="oc-details" aria-label="Refund destination">
                            <h3>Customer refund details</h3>
                            @if($cancellation->status === 'no_refund')
                                <p class="oc-muted mb-0">No captured online payment was found for this order. No refund is due.</p>
                            @else
                                <dl class="oc-data">
                                    <dt>Refund amount</dt><dd>₹{{ number_format((float) $cancellation->refund_amount, 2) }}</dd>
                                    <dt>Refund method</dt><dd>{{ strtoupper($cancellation->refund_method ?: '—') }}</dd>
                                    @if($cancellation->refund_method === 'upi')
                                        <dt>Customer UPI ID</dt><dd>{{ $cancellation->upi_id }}</dd>
                                    @elseif($cancellation->refund_method === 'bank')
                                        <dt>Account holder</dt><dd>{{ $cancellation->bank_account_holder }}</dd>
                                        <dt>Bank</dt><dd>{{ $cancellation->bank_name }}</dd>
                                        <dt>Account number</dt><dd>{{ $cancellation->bank_account_number }}</dd>
                                        <dt>IFSC</dt><dd>{{ $cancellation->bank_ifsc }}</dd>
                                    @endif
                                </dl>
                                @if($upiUri)
                                    <div class="oc-qr-wrap">
                                        <div class="oc-qr" data-upi-qr data-upi-uri="{{ $upiUri }}" aria-label="Refund UPI QR code"></div>
                                        <div class="oc-qr-note"><strong>Scan to pay this refund</strong>Verify customer name and ₹{{ number_format((float) $cancellation->refund_amount, 2) }} in your UPI app before confirming. QR is generated on this page.</div>
                                    </div>
                                @endif
                                @if($cancellation->status === 'refund_pending')
                                    <form class="oc-actions" method="POST" action="{{ route('seller.order-cancellations.refund-sent', $cancellation) }}" onsubmit="return confirm('Have you completed this refund to the customer?')">
                                        @csrf
                                        <input class="form-control" type="text" name="seller_transfer_reference" maxlength="120" placeholder="UTR / transfer reference (optional)">
                                        <button class="oc-done" type="submit"><i class="fa-solid fa-check me-1"></i>Mark refund sent</button>
                                    </form>
                                @else
                                    <p class="oc-muted mt-3 mb-0">{{ $cancellation->status === 'refunded' ? 'Marked sent ' . $cancellation->refund_sent_at?->format('d M Y, h:i A') : '' }} @if($cancellation->seller_transfer_reference)· Ref: {{ $cancellation->seller_transfer_reference }}@endif</p>
                                @endif
                            @endif
                        </section>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="oc-pagination">{{ $cancellations->links() }}</div>
    @endif
</section>

@if($cancellations->getCollection()->contains(fn ($item) => $item->refund_method === 'upi' && $item->status === 'refund_pending'))
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js" defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-upi-qr]').forEach((element) => {
            if (typeof window.QRCode === 'undefined') {
                element.textContent = 'QR unavailable';
                return;
            }
            new window.QRCode(element, {text: element.dataset.upiUri, width: 118, height: 118, correctLevel: window.QRCode.CorrectLevel.M});
        });
    });
    </script>
@endif
