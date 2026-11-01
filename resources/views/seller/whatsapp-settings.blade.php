@extends('seller.partials.premium-layout')

@section('title', 'WhatsApp PDF Bills')

@section('content')
@push('styles')
<style>
    .wa-page{width:100%;padding:24px clamp(14px,2.5vw,34px) 50px;color:#17243a}
    .wa-hero{position:relative;overflow:hidden;padding:clamp(24px,4vw,42px);border:1px solid #bfe8d0;border-radius:25px;background:radial-gradient(circle at 90% 0,rgba(37,211,102,.22),transparent 34%),linear-gradient(125deg,#f3fff7,#fff 62%,#f3f8ff);box-shadow:0 18px 50px rgba(20,83,55,.09)}
    .wa-kicker{color:#0b9b56;font-size:10px;font-weight:900;letter-spacing:.14em;text-transform:uppercase}.wa-hero h1{margin:8px 0;color:#123126;font-size:clamp(25px,3vw,36px);font-weight:950;letter-spacing:-.04em}.wa-hero p{max-width:760px;margin:0;color:#587168;font-size:13px;line-height:1.8}
    .wa-card{max-width:900px;margin:20px auto 0;padding:clamp(19px,3vw,32px);border:1px solid #e2e9ef;border-radius:22px;background:#fff;box-shadow:0 14px 40px rgba(21,43,68,.075)}
    .wa-alert{margin-bottom:17px;padding:13px 15px;border-radius:13px;font-size:12px;line-height:1.7}.wa-alert-success{border:1px solid #b9e6cb;background:#f0fcf4;color:#12643a}.wa-alert-error{border:1px solid #fecaca;background:#fff1f2;color:#9f1239}
    .wa-status{display:flex;align-items:center;gap:10px;margin-bottom:21px;padding:13px 15px;border:1px solid {{ $enabled ? '#b9e6cb' : '#e4e9f0' }};border-radius:14px;background:{{ $enabled ? '#f1fbf5' : '#f8fafc' }};color:{{ $enabled ? '#12643a' : '#607084' }};font-size:12px;font-weight:850}.wa-status i{font-size:17px}
    .wa-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.wa-field{min-width:0}.wa-field.full{grid-column:1/-1}.wa-field label{display:block;margin:0 0 7px;color:#30445d;font-size:12px;font-weight:850}.wa-field input{width:100%;min-height:46px;padding:10px 13px;border:1px solid #d5deea;border-radius:11px;color:#17243a;background:#fff}.wa-help{margin-top:6px;color:#738298;font-size:10px;line-height:1.65}.wa-error{display:block;margin-top:5px;color:#b4233a;font-size:11px;font-weight:750}
    .wa-toggle{display:flex;align-items:flex-start;gap:12px;margin-top:20px;padding:16px;border:1px solid #bfe8d0;border-radius:15px;background:#f4fff8}.wa-toggle input{width:18px;height:18px;flex:none;margin-top:2px;accent-color:#0b9b56}.wa-toggle strong{display:block;color:#173e2c;font-size:12px}.wa-toggle span{display:block;margin-top:4px;color:#668074;font-size:10px;line-height:1.6}
    .wa-submit{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:48px;margin-top:20px;padding:0 20px;border:0;border-radius:13px;background:linear-gradient(110deg,#0a9b57,#087c49);box-shadow:0 11px 24px rgba(12,139,76,.2);color:#fff;font-size:12px;font-weight:900;cursor:pointer}
    .wa-steps{display:grid;gap:10px;margin:0;padding-left:21px;color:#53657b;font-size:11px;line-height:1.7}.wa-steps strong{color:#21354e}.wa-note{margin-top:23px;padding:17px;border:1px solid #d9e6f6;border-radius:15px;background:#f5f9ff;color:#52657e;font-size:11px;line-height:1.7}.wa-note h2{margin:0 0 9px;color:#1b3c6a;font-size:13px;font-weight:900}
    .wa-setup-links{display:flex;flex-wrap:wrap;gap:10px;margin:12px 0 16px}.wa-setup-link{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 14px;border:1px solid #c9d9f0;border-radius:11px;background:#fff;color:#174a88;font-size:11px;font-weight:900;text-decoration:none;box-shadow:0 5px 14px rgba(31,73,125,.07);transition:transform .2s ease,box-shadow .2s ease}.wa-setup-link:hover{transform:translateY(-2px);box-shadow:0 9px 20px rgba(31,73,125,.13);color:#12396b}.wa-setup-link.primary{border-color:transparent;background:linear-gradient(110deg,#1769d2,#6846c7);color:#fff}
    @media(max-width:620px){.wa-page{padding:15px 12px 36px}.wa-fields{grid-template-columns:1fr}.wa-field.full{grid-column:auto}.wa-submit{width:100%}}
</style>
@endpush

<main class="wa-page">
    <header class="wa-hero">
        <div class="wa-kicker"><i class="fa-brands fa-whatsapp me-1" aria-hidden="true"></i> Seller invoice delivery</div>
        <h1>Automatic WhatsApp PDF bills</h1>
        <p>Connect your own WhatsApp Business Platform number. When a customer opts in and the order is confirmed, the invoice PDF will be sent from this connected seller number to the customer's checkout mobile.</p>
    </header>

    <section class="wa-card">
        @if(session('success'))<div class="wa-alert wa-alert-success" role="status">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="wa-alert wa-alert-error" role="alert">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif

        <div class="wa-status" role="status">
            <i class="fa-solid {{ $enabled ? 'fa-circle-check' : ($configured ? 'fa-circle-pause' : 'fa-circle-exclamation') }}" aria-hidden="true"></i>
            {{ $enabled ? 'Automatic sending is enabled' : ($configured ? 'WhatsApp is connected but sending is turned off' : 'Connect a WhatsApp Business sender to enable automatic bills') }}
        </div>

        <form method="POST" action="{{ route('seller.whatsapp.update') }}">
            @csrf
            @method('PUT')
            <div class="wa-fields">
                <div class="wa-field">
                    <label for="wa-business-phone">Connected WhatsApp Business number</label>
                    <input id="wa-business-phone" type="tel" name="whatsapp_business_phone" value="{{ old('whatsapp_business_phone', $seller->whatsapp_business_phone) }}" placeholder="+91 98765 43210" autocomplete="tel">
                    <div class="wa-help">This must be the sender number registered to the Phone Number ID below.</div>
                    @error('whatsapp_business_phone')<span class="wa-error">{{ $message }}</span>@enderror
                </div>
                <div class="wa-field">
                    <label for="wa-phone-id">Meta Phone Number ID</label>
                    <input id="wa-phone-id" type="text" name="whatsapp_phone_number_id" value="{{ old('whatsapp_phone_number_id', $seller->whatsapp_phone_number_id) }}" inputmode="numeric" placeholder="Numbers from Meta WhatsApp setup">
                    <div class="wa-help">Find this under your WhatsApp Business API phone-number settings.</div>
                    @error('whatsapp_phone_number_id')<span class="wa-error">{{ $message }}</span>@enderror
                </div>
                <div class="wa-field full">
                    <label for="wa-access-token">Permanent System User access token</label>
                    <input id="wa-access-token" type="password" name="whatsapp_access_token" value="" autocomplete="new-password" placeholder="{{ $configured ? 'Saved securely — leave blank to keep current token' : 'Paste the WhatsApp Business API token' }}">
                    <div class="wa-help">The token is encrypted before it is saved. It is never shown again. Leave blank to keep the saved token.</div>
                    @error('whatsapp_access_token')<span class="wa-error">{{ $message }}</span>@enderror
                </div>
                <div class="wa-field">
                    <label for="wa-template">Approved PDF invoice template name</label>
                    <input id="wa-template" type="text" name="whatsapp_invoice_template" value="{{ old('whatsapp_invoice_template', $seller->whatsapp_invoice_template) }}" placeholder="order_invoice_pdf">
                    <div class="wa-help">Use an approved utility template with a PDF document header and four body variables.</div>
                    @error('whatsapp_invoice_template')<span class="wa-error">{{ $message }}</span>@enderror
                </div>
                <div class="wa-field">
                    <label for="wa-language">Template language code</label>
                    <input id="wa-language" type="text" name="whatsapp_template_language" value="{{ old('whatsapp_template_language', $seller->whatsapp_template_language ?: 'en_US') }}" placeholder="en_US">
                    <div class="wa-help">This must match the language approved for your template.</div>
                    @error('whatsapp_template_language')<span class="wa-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <label class="wa-toggle" for="enableWhatsappInvoices">
                <input id="enableWhatsappInvoices" type="checkbox" name="enable_whatsapp_invoices" value="1" @checked(old('enable_whatsapp_invoices', $enabled))>
                <span><strong>Enable automatic PDF invoice delivery</strong><span>Invoices go only to customers who check the WhatsApp consent option at checkout. COD bills say Cash on Delivery; paid UPI/card bills include their payment transaction reference.</span></span>
            </label>
            @error('enable_whatsapp_invoices')<span class="wa-error">{{ $message }}</span>@enderror

            <button class="wa-submit" type="submit"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>Save WhatsApp settings</button>
        </form>

        <div class="wa-note">
            <h2>Meta setup checklist</h2>
            <p style="margin:0;color:#52657e">Naya setup shuru karne ke liye neeche button dabayein. Meta page login maang sakta hai.</p>
            <div class="wa-setup-links">
                <a class="wa-setup-link primary" href="https://developers.facebook.com/apps/" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-meta" aria-hidden="true"></i> Open Meta API Setup
                </a>
                <a class="wa-setup-link" href="https://business.facebook.com/wa/manage/phone-numbers/" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Add / verify WhatsApp number
                </a>
                <a class="wa-setup-link" href="https://developers.facebook.com/docs/whatsapp/cloud-api/get-started" target="_blank" rel="noopener noreferrer">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i> Setup guide
                </a>
            </div>
            <ol class="wa-steps">
                <li>Use the <strong>WhatsApp Business Platform / Cloud API</strong> for this seller's own business number and grant the app the WhatsApp messaging permission.</li>
                <li>Create and get approval for a <strong>Utility</strong> message template with a PDF document header and body placeholders in this order: order number, customer name, total amount, payment/reference ID.</li>
                <li>Paste the connected sender's Phone Number ID, permanent token, approved template name, and matching language above.</li>
                <li>Keep the Laravel queue worker running so confirmed orders can send their invoices.</li>
            </ol>
            <div class="wa-help">A personal WhatsApp number or ordinary <code>wa.me</code> link cannot send a PDF automatically from the seller's number.</div>
        </div>
    </section>
</main>
@endsection
