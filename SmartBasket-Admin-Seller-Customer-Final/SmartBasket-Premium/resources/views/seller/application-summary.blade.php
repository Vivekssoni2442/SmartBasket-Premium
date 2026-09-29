@extends('seller.partials.premium-layout')

@section('title', 'Review Seller Application')

@php
    $step = 6;
@endphp

@section('content')

<style>
    .review-page {
        --green: #16a34a;
        --green-light: #dcfce7;
        --green-soft: #f0fdf4;
        --text: #172033;
        --muted: #6b7280;
        --border: #e5e7eb;
        --card: #ffffff;
        --bg: #f6f8fb;

        max-width: 1050px;
        margin: 0 auto;
        padding: 30px 22px 60px;
        color: var(--text);
    }

    .review-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .07);
    }

    .review-top {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border);
    }

    .review-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: var(--green-light);
        color: var(--green);
        font-size: 20px;
    }

    .review-step {
        color: var(--green);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .review-title {
        margin: 4px 0 3px;
        font-size: 25px;
        font-weight: 800;
    }

    .review-description {
        margin: 0;
        color: var(--muted);
        font-size: 12px;
    }

    .summary {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 20px;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: #fafbfc;
        transition: .2s ease;
    }

    .summary-row:hover {
        border-color: #bbf7d0;
        background: var(--green-soft);
        transform: translateY(-1px);
    }

    .summary-label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .summary-value {
        margin-top: 4px;
        color: var(--text);
        font-size: 13px;
        font-weight: 700;
    }

    .edit-btn {
        flex-shrink: 0;
        padding: 9px 15px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #fff;
        color: #374151;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .edit-btn:hover {
        color: var(--green);
        border-color: #86efac;
        background: var(--green-soft);
    }

    .review-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 28px;
        padding-top: 23px;
        border-top: 1px solid var(--border);
    }

    .back-btn,
    .submit-btn {
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 12px;
        padding: 0 20px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: .25s ease;
    }

    .back-btn {
        background: #fff;
        color: #4b5563;
        border: 1px solid var(--border);
    }

    .back-btn:hover {
        background: #f9fafb;
        color: var(--text);
    }

    .submit-btn {
        border: none;
        color: #fff;
        background: linear-gradient(135deg, #16a34a, #15803d);
        box-shadow: 0 8px 22px rgba(22, 163, 74, .20);
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(22, 163, 74, .28);
    }

    @media(max-width:650px) {
        .review-page {
            padding: 18px 12px 45px;
        }

        .review-card {
            padding: 20px 15px;
            border-radius: 19px;
        }

        .review-title {
            font-size: 21px;
        }

        .summary-row {
            padding: 15px;
        }

        .review-actions {
            flex-direction: column-reverse;
        }

        .back-btn,
        .submit-btn {
            width: 100%;
        }
    }
</style>

<div class="review-page">

    <div class="review-card">

        <div class="review-top">

            <div class="review-icon">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>

            <div>
                <div class="review-step">
                    Seller Verification • Step 6 of 6
                </div>

                <h1 class="review-title">
                    Review your application
                </h1>

                <p class="review-description">
                    Check all information before submitting your seller application.
                </p>
            </div>

        </div>


        <div class="summary">

            <div class="summary-row">
                <div>
                    <div class="summary-label">Seller Name</div>
                    <div class="summary-value">
                        {{ $seller->seller_name }}
                    </div>
                </div>

                <a href="{{ route('seller.verification.email') }}" class="edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            </div>


            <div class="summary-row">
                <div>
                    <div class="summary-label">Business Type</div>
                    <div class="summary-value">
                        {{ $seller->business_type ?: 'Not provided' }}
                    </div>
                </div>

                <a href="{{ route('seller.verification.business-details') }}" class="edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            </div>


            <div class="summary-row">
                <div>
                    <div class="summary-label">Documents</div>

                    <div class="summary-value">
                        @if($seller->business_certificate_path && $seller->aadhaar_document_path)
                            <span style="color:#16a34a;">
                                ✓ Documents uploaded
                            </span>
                        @else
                            Documents incomplete
                        @endif
                    </div>
                </div>

                <a href="{{ route('seller.verification.documents') }}" class="edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            </div>


            <div class="summary-row">
                <div>
                    <div class="summary-label">Aadhaar Verification</div>

                    <div class="summary-value">
                        @if($seller->aadhaar_verified_at)
                            <span style="color:#16a34a;">
                                ✓ Verified
                            </span>
                        @else
                            Pending
                        @endif
                    </div>
                </div>

                <a href="{{ route('seller.verification.aadhaar') }}" class="edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            </div>


            <div class="summary-row">
                <div>
                    <div class="summary-label">Bank Account</div>

                    <div class="summary-value">
                        {{ $seller->bank_name ?: 'Not provided' }}
                    </div>
                </div>

                <a href="{{ route('seller.verification.bank-details') }}" class="edit-btn">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
            </div>

        </div>


        <div class="review-actions">

            <a
                href="{{ route('seller.verification.bank-details') }}"
                class="back-btn"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>


            <form
                method="POST"
                action="{{ route('seller.verification.submit') }}"
            >
                @csrf

                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-circle-check"></i>
                    Submit Seller Application
                </button>
            </form>

        </div>

    </div>

</div>

@endsection