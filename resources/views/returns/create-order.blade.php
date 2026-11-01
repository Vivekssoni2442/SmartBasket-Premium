@extends('layouts.app')
@section('title', 'Return Order #' . $order->id . ' | Smart Basket')
@section('content')
<style>
    .order-return-page{--ink:#18243a;--muted:#718096;--line:#e5ebf3;width:100%;max-width:none;margin:0;padding:clamp(18px,3vw,42px) clamp(14px,3.2vw,52px) 58px;color:var(--ink)}
    .order-return-page__hero{position:relative;overflow:hidden;padding:clamp(25px,4vw,44px);border:1px solid rgba(255,255,255,.16);border-radius:27px;background:radial-gradient(circle at 92% 4%,rgba(117,235,220,.32),transparent 27%),radial-gradient(circle at 5% 100%,rgba(160,112,255,.34),transparent 33%),linear-gradient(120deg,#102653,#1d4fbb 56%,#503a9c);color:#fff;box-shadow:0 22px 52px rgba(25,54,120,.22)}
    .order-return-page__hero h1{margin:0 0 8px;font-size:clamp(1.7rem,4vw,2.35rem);font-weight:900;letter-spacing:-.04em}.order-return-page__hero p{margin:0;color:rgba(239,244,255,.84)}
    .order-return-page__card{width:100%;margin-top:20px;padding:clamp(18px,3vw,34px);border:1px solid var(--line);border-radius:23px;background:linear-gradient(145deg,#fff,#fbfcff);box-shadow:0 16px 42px rgba(20,38,65,.075)}
    .order-return-line{display:grid;grid-template-columns:minmax(0,1fr) 190px;align-items:center;gap:22px;padding:18px 20px;border:1px solid var(--line);border-radius:17px;background:linear-gradient(115deg,#fff,#f7f9ff);box-shadow:0 5px 18px rgba(26,46,82,.035)}.order-return-line+.order-return-line{margin-top:12px}
    .order-return-product{display:flex;align-items:center;gap:13px;min-width:0}.order-return-product img{width:64px;height:64px;flex:none;object-fit:cover;border-radius:12px;background:#eef2f8}.order-return-product strong{display:block}.order-return-product small{display:block;margin-top:4px;color:var(--muted)}
    .order-return-quantity label{display:block;margin-bottom:5px;font-size:12px;font-weight:800}.order-return-quantity input{min-height:43px;border-radius:10px}
    .order-return-fields{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:22px}.order-return-fields label{display:block;margin-bottom:6px;font-weight:800}.order-return-fields .full{grid-column:1/-1}
    .order-return-submit{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:51px;margin-top:22px;padding:0 23px;border:1px solid rgba(255,255,255,.14);border-radius:15px;background:linear-gradient(115deg,#087d70,#2461d5 58%,#6846c7);box-shadow:0 12px 25px rgba(31,82,177,.22),inset 0 1px 0 rgba(255,255,255,.22);color:#fff!important;font-weight:850;text-decoration:none;transition:transform .18s ease,box-shadow .18s ease;cursor:pointer}.order-return-submit:hover{transform:translateY(-2px);box-shadow:0 16px 30px rgba(31,82,177,.3),inset 0 1px 0 rgba(255,255,255,.25)}.order-return-submit:focus-visible{outline:3px solid #84d9d0;outline-offset:3px}
    .order-return-empty{padding:clamp(22px,4vw,36px);border:1px dashed #cbd8ec;border-radius:18px;background:linear-gradient(145deg,#f8fbff,#f1f6ff);color:var(--muted);text-align:center}.order-return-empty__icon{display:grid;width:54px;height:54px;place-items:center;margin:0 auto 12px;border:1px solid #dbe7fb;border-radius:17px;background:#fff;color:#315bb4;font-size:20px}.order-return-empty h2{margin:0 0 8px;color:var(--ink);font-size:18px;font-weight:900}.order-return-empty p{max-width:640px;margin:0 auto 16px;line-height:1.65}.order-return-existing{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:10px auto;padding:13px 15px;max-width:680px;border:1px solid #e1e8f2;border-radius:13px;background:#fff;text-align:left}.order-return-existing strong{display:block;color:var(--ink);font-size:13px}.order-return-existing span{display:block;margin-top:4px;color:var(--muted);font-size:11px}.order-return-history{display:inline-flex;min-height:43px;align-items:center;gap:8px;padding:0 15px;border-radius:12px;background:linear-gradient(110deg,#2454d7,#6846c7);color:#fff!important;font-size:12px;font-weight:850;text-decoration:none}
    .order-return-errors{margin:0 0 18px;padding:14px 18px;border:1px solid #fecaca;border-radius:14px;background:#fff1f2;color:#9f1239}
    .order-return-errors ul{margin:7px 0 0;padding-left:20px}.order-return-field-error{display:block;margin-top:6px;color:#b42318;font-size:12px;font-weight:700}
    @media(max-width:620px){.order-return-page{padding:16px 12px 38px}.order-return-line{grid-template-columns:1fr;padding:14px}.order-return-fields{grid-template-columns:1fr}.order-return-fields .full{grid-column:auto}.order-return-submit{width:100%}}
</style>

<main class="order-return-page">
    <header class="order-return-page__hero">
        <h1>Return items from Order #{{ $order->id }}</h1>
        <p>Select only the products and quantities you want to return from this order.</p>
    </header>

    <section class="order-return-page__card" aria-label="Choose products from this order">
        @if($lines->isEmpty())
            <div class="order-return-empty">
                <span class="order-return-empty__icon"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i></span>
                <h2>No items left to return from this order</h2>
                @if($activeReturnRequests->isNotEmpty())
                    <p>The available quantity has already been included in a return request. Check its current status below. You can submit another request if an earlier request is rejected or cancelled.</p>
                    @foreach($activeReturnRequests as $existingReturn)
                        <a class="order-return-existing text-decoration-none" href="{{ route('returns.show', $existingReturn) }}">
                            <span><strong>Return request #{{ $existingReturn->id }}</strong><span>{{ ucfirst(str_replace('_', ' ', $existingReturn->status)) }} · Submitted {{ $existingReturn->created_at?->format('d M Y') }}</span></span>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @endforeach
                @else
                    <p>There is no remaining quantity available for a return request on this order.</p>
                @endif
                <a class="order-return-history" href="{{ route('returns.index') }}"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>View return history</a>
            </div>
        @else
            <form action="{{ route('returns.store', $order) }}" method="POST">
                @csrf
                @if($errors->any())
                    <div class="order-return-errors" role="alert" aria-live="polite">
                        <strong>Your return request was not submitted yet.</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @foreach($lines as $line)
                    <article class="order-return-line">
                        <div class="order-return-product">
                            <img src="{{ $line['product']?->image ? asset('products/' . $line['product']->image) : 'https://placehold.co/128x128/eef2f8/64748b?text=Item' }}" alt="{{ $line['name'] }}">
                            <div><strong>{{ $line['name'] }}</strong><small>Order #{{ $order->id }} · Rs. {{ number_format($line['unit_price'], 2) }} each · {{ $line['remaining'] }} eligible</small></div>
                        </div>
                        <div class="order-return-quantity">
                            <input type="hidden" name="items[{{ $line['index'] }}][product_id]" value="{{ $line['product_id'] }}">
                            <label for="return-quantity-{{ $line['index'] }}">Quantity to return</label>
                            <input id="return-quantity-{{ $line['index'] }}" type="number" class="form-control" name="items[{{ $line['index'] }}][quantity]" min="0" max="{{ $line['remaining'] }}" value="{{ old('items.' . $line['index'] . '.quantity', 0) }}" inputmode="numeric" aria-describedby="return-quantity-error-{{ $line['index'] }}">
                            @error('items.' . $line['index'] . '.quantity')<span class="order-return-field-error" id="return-quantity-error-{{ $line['index'] }}">{{ $message }}</span>@enderror
                        </div>
                    </article>
                @endforeach
                <div class="order-return-fields">
                    <div>
                        <label for="return-reason">Reason</label>
                        <select id="return-reason" name="reason" class="form-select" required>
                            <option value="">Choose a reason</option>
                            <option value="damaged" @selected(old('reason') === 'damaged')>Damaged</option>
                            <option value="defective" @selected(old('reason') === 'defective')>Defective</option>
                            <option value="wrong_item" @selected(old('reason') === 'wrong_item')>Wrong item</option>
                            <option value="not_as_described" @selected(old('reason') === 'not_as_described')>Not as described</option>
                            <option value="changed_mind" @selected(old('reason') === 'changed_mind')>Changed my mind</option>
                            <option value="replace" @selected(old('reason') === 'replace')>I want a replacement</option>
                            <option value="other" @selected(old('reason') === 'other')>Other</option>
                        </select>
                        @error('reason')<span class="order-return-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="full">@include('partials.refund-destination-fields')</div>
                    <div class="full">
                        <label for="return-description">Additional details (optional)</label>
                        <textarea id="return-description" name="description" maxlength="2000" rows="4" class="form-control">{{ old('description') }}</textarea>
                        @error('description')<span class="order-return-field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <button type="submit" class="order-return-submit"><i class="fa-solid fa-paper-plane me-1" aria-hidden="true"></i>Submit return for Order #{{ $order->id }}</button>
            </form>
        @endif
    </section>
</main>
@if($lines->isNotEmpty())
<script>
    (() => {
        const form = document.querySelector('.order-return-page form');
        if (!form) return;
        form.addEventListener('submit', (event) => {
            const quantities = [...form.querySelectorAll('input[name$="[quantity]"]')];
            const hasSelection = quantities.some((input) => Number.parseInt(input.value, 10) > 0);
            if (!hasSelection) {
                event.preventDefault();
                let notice = form.querySelector('[data-return-selection-error]');
                if (!notice) {
                    notice = document.createElement('div');
                    notice.className = 'order-return-errors';
                    notice.dataset.returnSelectionError = 'true';
                    notice.setAttribute('role', 'alert');
                    notice.textContent = 'Choose a quantity greater than zero for at least one product.';
                    form.prepend(notice);
                }
                notice.scrollIntoView({ behavior: 'smooth', block: 'center' });
                quantities[0]?.focus({ preventScroll: true });
                return;
            }
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>Submitting return request…';
            }
        });
    })();
</script>
@endif
@endsection
