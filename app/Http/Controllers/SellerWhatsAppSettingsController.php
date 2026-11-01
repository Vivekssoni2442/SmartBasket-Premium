<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;

class SellerWhatsAppSettingsController extends Controller
{
    public function index()
    {
        $seller = $this->currentSeller();

        return view('seller.whatsapp-settings', [
            'seller' => $seller,
            'configured' => filled($seller->whatsapp_phone_number_id)
                && filled($seller->whatsapp_access_token)
                && filled($seller->whatsapp_invoice_template),
            'enabled' => (bool) ($seller->whatsapp_invoice_enabled
                && $seller->whatsapp_business_phone
                && $seller->whatsapp_phone_number_id
                && $seller->whatsapp_access_token
                && $seller->whatsapp_invoice_template),
        ]);
    }

    public function update(Request $request)
    {
        $seller = $this->currentSeller();
        $validated = $request->validate([
            'whatsapp_business_phone' => ['nullable', 'string', 'max:30', 'regex:/^\+?[0-9 ()-]{8,25}$/'],
            'whatsapp_phone_number_id' => ['nullable', 'string', 'max:80', 'regex:/^[0-9]+$/'],
            'whatsapp_access_token' => ['nullable', 'string', 'max:5000'],
            'whatsapp_invoice_template' => ['nullable', 'string', 'max:100', 'regex:/^[a-z0-9_]+$/'],
            'whatsapp_template_language' => ['nullable', 'string', 'max:20', 'regex:/^[a-z]{2,3}_[A-Z]{2,4}$/'],
            'enable_whatsapp_invoices' => ['nullable', 'boolean'],
            'clear_whatsapp_token' => ['nullable', 'boolean'],
        ]);

        $seller->whatsapp_business_phone = trim((string) ($validated['whatsapp_business_phone'] ?? '')) ?: null;
        $seller->whatsapp_phone_number_id = trim((string) ($validated['whatsapp_phone_number_id'] ?? '')) ?: null;
        $seller->whatsapp_invoice_template = trim((string) ($validated['whatsapp_invoice_template'] ?? '')) ?: null;
        $seller->whatsapp_template_language = trim((string) ($validated['whatsapp_template_language'] ?? 'en_US')) ?: 'en_US';

        if (! empty($validated['clear_whatsapp_token'])) {
            $seller->whatsapp_access_token = null;
        } elseif (filled($validated['whatsapp_access_token'] ?? null)) {
            $seller->whatsapp_access_token = trim($validated['whatsapp_access_token']);
        }

        $ready = filled($seller->whatsapp_business_phone)
            && filled($seller->whatsapp_phone_number_id)
            && filled($seller->whatsapp_access_token)
            && filled($seller->whatsapp_invoice_template);
        if ($request->boolean('enable_whatsapp_invoices') && ! $ready) {
            return back()->withErrors(['enable_whatsapp_invoices' => 'Add the connected WhatsApp Business number, Phone Number ID, access token, and approved invoice template before enabling automatic PDF bills.'])->withInput();
        }

        $seller->whatsapp_invoice_enabled = $request->boolean('enable_whatsapp_invoices') && $ready;
        $seller->save();

        return back()->with('success', 'WhatsApp invoice settings saved. Automatic sending is ' . ($request->boolean('enable_whatsapp_invoices') ? 'ready for opted-in orders.' : 'currently turned off.'));
    }

    private function currentSeller(): SellerProfile
    {
        abort_unless(session('seller_login') && session('seller_id'), 401);

        return SellerProfile::findOrFail((int) session('seller_id'));
    }
}
