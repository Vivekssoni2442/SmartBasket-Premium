@extends('seller.partials.premium-layout')

@section('title', 'Bank Details')

@php
    $step = 5;
@endphp

@section('content')

<div class="sb-card">

    <div class="sb-step">
        STEP 5 OF 6
    </div>

    <h1 class="sb-title">
        Add your bank details
    </h1>

    <p class="sb-description">
        Enter the bank account details that will be used for your
        seller payments. You can return and edit these details later.
    </p>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))
        <div class="sb-alert sb-alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- ERROR MESSAGE --}}

    @if(session('error'))
        <div class="sb-alert sb-alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- VALIDATION ERRORS --}}

    @if($errors->any())
        <div class="sb-alert sb-alert-error">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('seller.verification.bank-details.update') }}"
    >

        @csrf
        @method('PUT')


        <div class="sb-grid">


            {{-- ACCOUNT HOLDER --}}

            <div class="sb-field">

                <label class="sb-label">
                    Account Holder Name *
                </label>

                <input
                    type="text"
                    name="bank_account_holder"
                    class="sb-input"
                    value="{{ old('bank_account_holder', $seller->bank_account_holder) }}"
                    placeholder="Enter account holder name"
                    autocomplete="name"
                    required
                >

            </div>


            {{-- ACCOUNT NUMBER --}}

            <div class="sb-field">

                <label class="sb-label">
                    Account Number *
                </label>

                <input
                    type="password"
                    name="bank_account_number"
                    class="sb-input"
                    inputmode="numeric"
                    autocomplete="new-password"
                    placeholder="Enter bank account number"
                    required
                >

                @if($seller->bank_account_number)
                    <small>
                        Existing account number is saved securely.
                        Enter it again only if you want to replace it.
                    </small>
                @endif

            </div>


            {{-- CONFIRM ACCOUNT NUMBER --}}

            <div class="sb-field">

                <label class="sb-label">
                    Confirm Account Number *
                </label>

                <input
                    type="password"
                    name="bank_account_number_confirmation"
                    class="sb-input"
                    inputmode="numeric"
                    autocomplete="new-password"
                    placeholder="Confirm bank account number"
                    required
                >

            </div>


            {{-- IFSC --}}

            <div class="sb-field">

                <label class="sb-label">
                    IFSC Code *
                </label>

                <input
                    type="text"
                    name="bank_ifsc"
                    class="sb-input"
                    value="{{ old('bank_ifsc', $seller->bank_ifsc) }}"
                    placeholder="Enter IFSC code"
                    autocomplete="off"
                    maxlength="20"
                    style="text-transform:uppercase;"
                    required
                >

            </div>


            {{-- BANK NAME --}}

            <div class="sb-field">

                <label class="sb-label">
                    Bank Name *
                </label>

                <input
                    type="text"
                    name="bank_name"
                    class="sb-input"
                    value="{{ old('bank_name', $seller->bank_name) }}"
                    placeholder="Enter bank name"
                    autocomplete="organization"
                    required
                >

            </div>


            {{-- BANK PROOF --}}

            <div class="sb-field">

                <label class="sb-label">
                    Bank Proof
                </label>

                <input
                    type="file"
                    name="bank_proof"
                    class="sb-input"
                    accept=".pdf,.jpg,.jpeg,.png,.webp"
                >

                <small>
                    Optional. PDF, JPG, JPEG, PNG or WEBP.
                    Maximum 5 MB.
                </small>

            </div>

        </div>


        <div class="sb-actions">


            {{-- BACK TO STEP 4 --}}

            <a
                href="{{ route('seller.verification.business-details') }}"
                class="sb-btn"
            >
                ← Back
            </a>


            {{-- SAVE AND CONTINUE TO STEP 6 --}}

            <button
                type="submit"
                class="sb-btn sb-btn-primary"
            >
                Save & Continue →
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (event) {

        const accountNumber =
            form.querySelector(
                '[name="bank_account_number"]'
            );

        const confirmation =
            form.querySelector(
                '[name="bank_account_number_confirmation"]'
            );

        if (
            accountNumber &&
            confirmation &&
            accountNumber.value !== confirmation.value
        ) {

            event.preventDefault();

            alert(
                'Bank account number and confirmation do not match.'
            );

            confirmation.focus();
        }

    });

});

</script>

@endsection