@php
    $refundProfile = auth()->user();
    $preferredRefundMethod = old('refund_method')
        ?: (filled($refundProfile?->refund_upi_id) ? 'upi' : (filled($refundProfile?->refund_account_number) ? 'bank' : 'upi'));
@endphp

<style>
    .refund-destination { margin: 22px 0; padding: 19px; border: 1px solid #dfe7f1; border-radius: 16px; background: linear-gradient(135deg,#f9fbff,#f2f7ff); }
    .refund-destination h3 { margin: 0 0 6px; font-size: 1rem; font-weight: 850; }
    .refund-destination__hint { margin: 0 0 14px; color: #64748b; font-size: .83rem; line-height: 1.55; }
    .refund-destination__choice { display: flex; min-height: 56px; align-items: flex-start; gap: 10px; padding: 13px; border: 1px solid #dce4ef; border-radius: 12px; background: #fff; cursor: pointer; }
    .refund-destination__choice input { margin-top: 3px; accent-color: #3159d8; }
    .refund-destination__fields { margin-top: 14px; }
    .refund-destination [hidden] { display: none !important; }
</style>

<section class="refund-destination" aria-labelledby="refundDestinationTitle">
    <h3 id="refundDestinationTitle">Where should the seller send your money?</h3>
    <p class="refund-destination__hint">Choose UPI or bank transfer. Your saved profile details fill in automatically; you can update them here. The details are stored securely for this request.</p>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="refund-destination__choice">
                <input type="radio" name="refund_method" value="upi" @checked($preferredRefundMethod === 'upi')>
                <span><strong>UPI ID</strong><small class="d-block text-muted mt-1">The seller can pay to your UPI app.</small></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="refund-destination__choice">
                <input type="radio" name="refund_method" value="bank" @checked($preferredRefundMethod === 'bank')>
                <span><strong>Bank account</strong><small class="d-block text-muted mt-1">The seller can transfer to your bank.</small></span>
            </label>
        </div>
    </div>
    @error('refund_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

    <div class="refund-destination__fields" data-refund-fields="upi" @if($preferredRefundMethod !== 'upi') hidden @endif>
        <label class="form-label" for="refund_upi_id_input">Your UPI ID</label>
        <input id="refund_upi_id_input" class="form-control" name="upi_id" value="{{ old('upi_id', $refundProfile?->refund_upi_id) }}" maxlength="120" placeholder="name@bank" autocomplete="off" @required($preferredRefundMethod === 'upi')>
        @error('upi_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>

    <div class="refund-destination__fields row g-3" data-refund-fields="bank" @if($preferredRefundMethod !== 'bank') hidden @endif>
        <div class="col-md-6">
            <label class="form-label" for="refund_bank_holder_input">Account holder name</label>
            <input id="refund_bank_holder_input" class="form-control" name="bank_account_holder" value="{{ old('bank_account_holder', $refundProfile?->refund_account_holder) }}" maxlength="150" autocomplete="name" @required($preferredRefundMethod === 'bank')>
            @error('bank_account_holder')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label" for="refund_bank_name_input">Bank name</label>
            <input id="refund_bank_name_input" class="form-control" name="bank_name" value="{{ old('bank_name', $refundProfile?->refund_bank_name) }}" maxlength="150" autocomplete="organization" @required($preferredRefundMethod === 'bank')>
            @error('bank_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-7">
            <label class="form-label" for="refund_bank_account_input">Account number</label>
            <input id="refund_bank_account_input" class="form-control" name="bank_account_number" value="{{ old('bank_account_number', $refundProfile?->refund_account_number) }}" inputmode="numeric" minlength="6" maxlength="20" autocomplete="off" @required($preferredRefundMethod === 'bank')>
            @error('bank_account_number')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-5">
            <label class="form-label" for="refund_bank_ifsc_input">IFSC code</label>
            <input id="refund_bank_ifsc_input" class="form-control text-uppercase" name="bank_ifsc" value="{{ old('bank_ifsc', $refundProfile?->refund_ifsc) }}" maxlength="11" autocapitalize="characters" autocomplete="off" @required($preferredRefundMethod === 'bank')>
            @error('bank_ifsc')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
    </div>
</section>

<script>
(() => {
    const radios = document.querySelectorAll('input[name="refund_method"]');
    const sections = document.querySelectorAll('[data-refund-fields]');
    const sync = () => {
        const method = document.querySelector('input[name="refund_method"]:checked')?.value;
        sections.forEach((section) => {
            const active = section.dataset.refundFields === method;
            section.hidden = !active;
            section.querySelectorAll('input').forEach((input) => input.required = active);
        });
    };
    radios.forEach((radio) => radio.addEventListener('change', sync));
    sync();
})();
</script>
