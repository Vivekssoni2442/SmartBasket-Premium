<x-seller-verification.layout>

    <h2>
        Step 1: Email Verification
    </h2>

    <p>
        Verify your registered seller email address.
        A secure 16-digit verification code will be sent
        to your registered email.
    </p>

    {{-- Send Code --}}

    <form
        method="POST"
        action="{{ route('seller.verification.email.send') }}"
    >

        @csrf

        <label for="email">
            Registered Seller Email
        </label>

        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $seller->email ?? '') }}"
            placeholder="seller@example.com"
            autocomplete="email"
            required
        >

        <button type="submit">
            Send Verification Code
        </button>

    </form>

    {{-- Verify Code --}}

    <hr>

    <form
        method="POST"
        action="{{ route('seller.verification.email.verify') }}"
    >

        @csrf

        <label for="code">
            16-digit Verification Code
        </label>

        <input
            id="code"
            type="text"
            name="code"
            inputmode="numeric"
            pattern="[0-9]{16}"
            maxlength="16"
            placeholder="Enter 16-digit code"
            required
        >

        <button type="submit">
            Verify Email
        </button>

    </form>

</x-seller-verification.layout>