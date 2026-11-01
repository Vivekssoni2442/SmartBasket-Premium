<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SellerSettingsController extends Controller
{
    /**
     * Open seller settings page.
     */
    public function index()
    {
        $seller = $this->currentSeller();

        $preferences = array_merge(
            $this->defaultPreferences(),
            is_array($seller->preferences)
                ? $seller->preferences
                : []
        );

        return view('seller.settings', [
            'seller' => $seller,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Save ALL seller settings.
     */
    public function update(Request $request)
    {
        $seller = $this->currentSeller();

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'theme' => [
                'required',
                'in:light,dark,system',
            ],

            'notifications_enabled' => [
                'nullable',
                'boolean',
            ],

            'online_payments_enabled' => [
                'nullable',
                'boolean',
            ],

            'payment_upi_id' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9][a-zA-Z0-9._-]{1,252}@[a-zA-Z][a-zA-Z0-9.-]{1,63}$/',
            ],

            'payment_mobile_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(?:(?:\+91|91)[ -]?)?[6-9][0-9]{9}$/',
            ],

            'payment_business_name' => [
                'nullable',
                'string',
                'max:150',
            ],

            'payment_status' => [
                'nullable',
                'in:enabled,disabled,verification_pending,verified,manual_review',
            ],

            'preferences' => [
                'nullable',
                'array',
            ],

            /*
            |--------------------------------------------------------------------------
            | UPI PAYMENT
            |--------------------------------------------------------------------------
            */
            'preferences.upi_id' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9][a-zA-Z0-9._-]{1,252}@[a-zA-Z][a-zA-Z0-9.-]{1,63}$/',
            ],

            /*
            |--------------------------------------------------------------------------
            | Delivery
            |--------------------------------------------------------------------------
            */
            'preferences.shipping_enabled' => 'nullable|boolean',
            'preferences.seller_delivery' => 'nullable|boolean',
            'preferences.platform_delivery' => 'nullable|boolean',
            'preferences.pickup_option' => 'nullable|boolean',
            'preferences.same_day_delivery' => 'nullable|boolean',
            'preferences.express_delivery' => 'nullable|boolean',

            'preferences.delivery_charge' => 'nullable|numeric|min:0|max:1000000',
            'preferences.free_shipping_threshold' => 'nullable|numeric|min:0|max:10000000',
            'preferences.estimated_delivery_days' => 'nullable|integer|min:1|max:365',

            /*
            |--------------------------------------------------------------------------
            | Orders
            |--------------------------------------------------------------------------
            */
            'preferences.auto_accept_orders' => 'nullable|boolean',
            'preferences.allow_order_cancellation' => 'nullable|boolean',
            'preferences.allow_return_requests' => 'nullable|boolean',
            'preferences.allow_exchange_requests' => 'nullable|boolean',
            'preferences.auto_update_order_status' => 'nullable|boolean',

            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */
            'preferences.order_confirmation_notification' => 'nullable|boolean',
            'preferences.delivery_status_notification' => 'nullable|boolean',
            'preferences.new_order_notification' => 'nullable|boolean',
            'preferences.order_cancellation_notification' => 'nullable|boolean',
            'preferences.payment_received_notification' => 'nullable|boolean',
            'preferences.payment_failed_notification' => 'nullable|boolean',
            'preferences.low_stock_alert' => 'nullable|boolean',
            'preferences.customer_message_notification' => 'nullable|boolean',
            'preferences.seller_verification_notification' => 'nullable|boolean',
            'preferences.promotional_notifications' => 'nullable|boolean',
            'preferences.email_notifications' => 'nullable|boolean',
            'preferences.browser_notifications' => 'nullable|boolean',

            /*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */
            'preferences.default_product_status' => 'nullable|in:active,inactive',
            'preferences.default_rating' => 'nullable|numeric|min:0|max:5',
            'preferences.low_stock_threshold' => 'nullable|integer|min:0|max:100000',

            'preferences.allow_customer_reviews' => 'nullable|boolean',
            'preferences.allow_customer_questions' => 'nullable|boolean',
            'preferences.show_stock_quantity' => 'nullable|boolean',
            'preferences.product_visibility_enabled' => 'nullable|boolean',
            'preferences.auto_hide_out_of_stock' => 'nullable|boolean',

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */
            'preferences.profile_visibility' => 'nullable|boolean',
            'preferences.shop_visibility' => 'nullable|boolean',
            'preferences.show_mobile_number' => 'nullable|boolean',
            'preferences.show_email' => 'nullable|boolean',
            'preferences.show_business_information' => 'nullable|boolean',

            /*
            |--------------------------------------------------------------------------
            | Customer communication
            |--------------------------------------------------------------------------
            */
            'preferences.allow_customer_messages' => 'nullable|boolean',
            'preferences.auto_reply' => 'nullable|boolean',

            'preferences.welcome_message' => 'nullable|string|max:1000',
            'preferences.order_message' => 'nullable|string|max:1000',
            'preferences.cancellation_message' => 'nullable|string|max:1000',
            'preferences.delivery_message' => 'nullable|string|max:1000',

            /*
            |--------------------------------------------------------------------------
            | Invoice
            |--------------------------------------------------------------------------
            */
            'preferences.show_seller_logo_on_invoice' => 'nullable|boolean',
            'preferences.show_gst_on_invoice' => 'nullable|boolean',
            'preferences.show_seller_address_on_invoice' => 'nullable|boolean',
            'preferences.show_customer_address_on_invoice' => 'nullable|boolean',
            'preferences.show_payment_details_on_invoice' => 'nullable|boolean',
            'preferences.show_qr_on_invoice' => 'nullable|boolean',

            'preferences.invoice_prefix' => 'nullable|string|max:30',
            'preferences.invoice_footer' => 'nullable|string|max:1000',

            /*
            |--------------------------------------------------------------------------
            | Store
            |--------------------------------------------------------------------------
            */
            'preferences.store_active' => 'nullable|boolean',
            'preferences.temporarily_closed' => 'nullable|boolean',
            'preferences.vacation_mode' => 'nullable|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Existing preferences
        |--------------------------------------------------------------------------
        */
        $currentPreferences = array_merge(
            $this->defaultPreferences(),
            is_array($seller->preferences)
                ? $seller->preferences
                : []
        );

        /*
        |--------------------------------------------------------------------------
        | Incoming preferences
        |--------------------------------------------------------------------------
        */
        $incomingPreferences = $validated['preferences'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | UPI ID
        |--------------------------------------------------------------------------
        |
        | UPI ID database ke preferences JSON me permanently save hoti hai.
        | Session/localStorage par depend nahi karti.
        |
        */
        if ($request->has('preferences.upi_id')) {
            $upiId = trim(
                (string) $request->input('preferences.upi_id')
            );

            $incomingPreferences['upi_id'] =
                $upiId !== '' ? $upiId : null;
        }

        /*
        |--------------------------------------------------------------------------
        | Checkbox fields
        |--------------------------------------------------------------------------
        |
        | HTML unchecked checkboxes submit nahi hote.
        | request->boolean() checked/unchecked ko safely handle karta hai.
        |
        */
        $booleanFields = [
            // Delivery
            'shipping_enabled',
            'seller_delivery',
            'platform_delivery',
            'pickup_option',
            'same_day_delivery',
            'express_delivery',

            // Orders
            'auto_accept_orders',
            'allow_order_cancellation',
            'allow_return_requests',
            'allow_exchange_requests',
            'auto_update_order_status',

            // Notifications
            'order_confirmation_notification',
            'delivery_status_notification',
            'new_order_notification',
            'order_cancellation_notification',
            'payment_received_notification',
            'payment_failed_notification',
            'low_stock_alert',
            'customer_message_notification',
            'seller_verification_notification',
            'promotional_notifications',
            'email_notifications',
            'browser_notifications',

            // Products
            'allow_customer_reviews',
            'allow_customer_questions',
            'show_stock_quantity',
            'product_visibility_enabled',
            'auto_hide_out_of_stock',

            // Visibility
            'profile_visibility',
            'shop_visibility',
            'show_mobile_number',
            'show_email',
            'show_business_information',

            // Customer communication
            'allow_customer_messages',
            'auto_reply',

            // Invoice
            'show_seller_logo_on_invoice',
            'show_gst_on_invoice',
            'show_seller_address_on_invoice',
            'show_customer_address_on_invoice',
            'show_payment_details_on_invoice',
            'show_qr_on_invoice',

            // Store
            'store_active',
            'temporarily_closed',
            'vacation_mode',
        ];

        foreach ($booleanFields as $field) {
            if ($request->has("preferences.$field")) {
                $incomingPreferences[$field] = $request->boolean(
                    "preferences.$field"
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Non-checkbox fields
        |--------------------------------------------------------------------------
        */
        $valueFields = [
            'delivery_charge',
            'free_shipping_threshold',
            'estimated_delivery_days',

            'default_product_status',
            'default_rating',
            'low_stock_threshold',

            'welcome_message',
            'order_message',
            'cancellation_message',
            'delivery_message',

            'invoice_prefix',
            'invoice_footer',
        ];

        foreach ($valueFields as $field) {
            if ($request->has("preferences.$field")) {
                $incomingPreferences[$field] =
                    $request->input("preferences.$field");
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Merge old + new preferences
        |--------------------------------------------------------------------------
        */
        $preferences = array_merge(
            $currentPreferences,
            $incomingPreferences
        );

        /*
        |--------------------------------------------------------------------------
        | Store status protection
        |--------------------------------------------------------------------------
        |
        | Vacation mode OR temporary close automatically closes store.
        |
        */
        if (
            !empty($preferences['vacation_mode']) ||
            !empty($preferences['temporarily_closed'])
        ) {
            $preferences['store_active'] = false;
        }

        /*
        |--------------------------------------------------------------------------
        | Save seller settings
        |--------------------------------------------------------------------------
        |
        | online_payments_enabled:
        | Direct seller_profiles database column.
        |
        | UPI ID:
        | preferences JSON ke andar database me permanent.
        |
        | Dono session/localStorage par dependent nahi hain.
        |
        */
        $seller->theme = $validated['theme'];

        if ($request->has('notifications_enabled')) {
            $seller->notifications_enabled =
                $request->boolean('notifications_enabled');
        }

        $onlinePaymentsEnabled = $request->has('online_payments_enabled')
            ? $request->boolean('online_payments_enabled')
            : (bool) $seller->online_payments_enabled;

        $paymentUpiId = trim((string) ($request->input('payment_upi_id') ?? $incomingPreferences['upi_id'] ?? $seller->payment_upi_id ?? ''));
        $paymentMobileNumber = trim((string) ($request->input('payment_mobile_number') ?? $seller->payment_mobile_number ?? $seller->mobile_number ?? $seller->phone ?? ''));
        $paymentBusinessName = trim((string) ($request->input('payment_business_name') ?? $seller->payment_business_name ?? $seller->shop_name ?? $seller->seller_name ?? ''));

        $paymentSettingsSubmitted = $request->has('payment_upi_id')
            || $request->has('payment_mobile_number')
            || $request->has('payment_business_name');

        if ($paymentSettingsSubmitted && $onlinePaymentsEnabled && $paymentUpiId === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'payment_upi_id' => 'Enter a valid seller UPI ID before enabling UPI payments.',
            ]);
        }

        $onlinePaymentToggleChanged = $request->has('online_payments_enabled')
            && $onlinePaymentsEnabled !== (bool) $seller->online_payments_enabled;

        if ($paymentSettingsSubmitted || $onlinePaymentToggleChanged) {
            $destinationChanged = $paymentUpiId !== (string) $seller->payment_upi_id
                || $paymentMobileNumber !== (string) $seller->payment_mobile_number
                || $paymentBusinessName !== (string) $seller->payment_business_name;

            if ($paymentUpiId !== '') {
                $incomingPreferences['upi_id'] = $paymentUpiId;
                $preferences['upi_id'] = $paymentUpiId;
            }

            $seller->payment_upi_id = $paymentUpiId !== '' ? $paymentUpiId : null;
            $seller->payment_mobile_number = $paymentMobileNumber !== '' ? $paymentMobileNumber : null;
            $seller->payment_business_name = $paymentBusinessName !== '' ? $paymentBusinessName : null;
            $seller->payment_status = $onlinePaymentsEnabled ? 'enabled' : 'disabled';
            $seller->payment_provider = 'upi';
            if ($destinationChanged) {
                $seller->payment_verification_status = 'verification_pending';
                $seller->payment_verified_at = null;
            } elseif (! $seller->payment_verification_status) {
                $seller->payment_verification_status = 'verification_pending';
            }
            $seller->payment_enabled = $onlinePaymentsEnabled;
            $seller->online_payments_enabled = $onlinePaymentsEnabled;
        }
        $seller->preferences = $preferences;

        $seller->save();

        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'success',
            'All seller settings saved successfully.'
        );
    }

    /**
     * Change seller password.
     */
    public function updatePassword(Request $request)
    {
        $seller = $this->currentSeller();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        if (!Hash::check(
            $validated['current_password'],
            $seller->password
        )) {
            return back()->withErrors([
                'current_password' =>
                    'Current password is incorrect.',
            ]);
        }

        $seller->password = Hash::make(
            $validated['password']
        );

        $seller->save();

        return back()->with(
            'success',
            'Password changed successfully.'
        );
    }

    /**
     * Upload seller payment QR.
     */
    public function updatePaymentQr(Request $request)
    {
        $seller = $this->currentSeller();

        $validated = $request->validate([
            'payment_qr' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'return_to' => ['nullable', 'in:profile,settings'],
        ]);

        $path = $validated['payment_qr']->store(
            'seller-payment-qr',
            'public'
        );

        $oldPath = ltrim((string) $seller->payment_qr, '/');
        if (str_starts_with($oldPath, 'storage/')) {
            $oldPath = substr($oldPath, strlen('storage/'));
        }

        $seller->payment_qr = $path;
        $seller->save();

        // Keep the previous image available unless the new upload was saved.
        if ($oldPath !== '' && $oldPath !== $path) {
            Storage::disk('public')->delete($oldPath);
        }

        $destination = ($validated['return_to'] ?? null) === 'profile' ? 'seller.profile' : 'seller.settings';

        return redirect()->route($destination)->with(
            'success',
            'Payment QR updated successfully.'
        );
    }

    /**
     * Delete payment QR.
     */
    public function deletePaymentQr(Request $request)
    {
        $destination = $request->validate([
            'return_to' => ['nullable', 'in:profile,settings'],
        ])['return_to'] ?? null;
        $seller = $this->currentSeller();
        $oldPath = ltrim((string) $seller->payment_qr, '/');

        if (str_starts_with($oldPath, 'storage/')) {
            $oldPath = substr($oldPath, strlen('storage/'));
        }

        $seller->payment_qr = null;
        $seller->save();

        if ($oldPath !== '') {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route($destination === 'profile' ? 'seller.profile' : 'seller.settings')->with(
            'success',
            'Payment QR removed successfully.'
        );
    }

    /**
     * Default settings.
     */
    private function defaultPreferences(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | UPI PAYMENT
            |--------------------------------------------------------------------------
            */
            'upi_id' => null,

            /*
            |--------------------------------------------------------------------------
            | Delivery
            |--------------------------------------------------------------------------
            */
            'shipping_enabled' => true,
            'seller_delivery' => true,
            'platform_delivery' => false,
            'pickup_option' => false,
            'same_day_delivery' => false,
            'express_delivery' => false,

            'delivery_charge' => 0,
            'free_shipping_threshold' => 0,
            'estimated_delivery_days' => 3,

            /*
            |--------------------------------------------------------------------------
            | Orders
            |--------------------------------------------------------------------------
            */
            'auto_accept_orders' => false,
            'allow_order_cancellation' => true,
            'allow_return_requests' => true,
            'allow_exchange_requests' => false,
            'auto_update_order_status' => false,

            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */
            'order_confirmation_notification' => true,
            'delivery_status_notification' => true,
            'new_order_notification' => true,
            'order_cancellation_notification' => true,
            'payment_received_notification' => true,
            'payment_failed_notification' => true,
            'low_stock_alert' => true,
            'customer_message_notification' => true,
            'seller_verification_notification' => true,
            'promotional_notifications' => false,
            'email_notifications' => true,
            'browser_notifications' => false,

            /*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */
            'default_product_status' => 'active',
            'default_rating' => 4.5,
            'low_stock_threshold' => 5,

            'allow_customer_reviews' => true,
            'allow_customer_questions' => true,
            'show_stock_quantity' => true,
            'product_visibility_enabled' => true,
            'auto_hide_out_of_stock' => false,

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */
            'profile_visibility' => true,
            'shop_visibility' => true,
            'show_mobile_number' => false,
            'show_email' => false,
            'show_business_information' => true,

            /*
            |--------------------------------------------------------------------------
            | Customer communication
            |--------------------------------------------------------------------------
            */
            'allow_customer_messages' => true,
            'auto_reply' => false,

            'welcome_message' => '',
            'order_message' => '',
            'cancellation_message' => '',
            'delivery_message' => '',

            /*
            |--------------------------------------------------------------------------
            | Invoice
            |--------------------------------------------------------------------------
            */
            'show_seller_logo_on_invoice' => true,
            'show_gst_on_invoice' => true,
            'show_seller_address_on_invoice' => true,
            'show_customer_address_on_invoice' => true,
            'show_payment_details_on_invoice' => true,
            'show_qr_on_invoice' => false,

            'invoice_prefix' => 'SB-',
            'invoice_footer' => '',

            /*
            |--------------------------------------------------------------------------
            | Store
            |--------------------------------------------------------------------------
            */
            'store_active' => true,
            'temporarily_closed' => false,
            'vacation_mode' => false,
        ];
    }

    /**
     * Get currently logged-in seller.
     */
    private function currentSeller(): SellerProfile
    {
        $sellerId = session('seller_id');

        abort_unless(
            session('seller_login') && $sellerId,
            401
        );

        return SellerProfile::findOrFail($sellerId);
    }
}
