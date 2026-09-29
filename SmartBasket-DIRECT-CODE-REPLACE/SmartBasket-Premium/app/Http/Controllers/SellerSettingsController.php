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

        return view('seller.settings', compact(
            'seller',
            'preferences'
        ));
    }

    /**
     * Save ALL seller settings.
     */
    public function update(Request $request)
    {
        $seller = $this->currentSeller();

        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'notifications_enabled' => 'nullable|boolean',
            'online_payments_enabled' => 'nullable|boolean',

            'preferences' => 'nullable|array',

            'preferences.shipping_enabled' => 'nullable|boolean',
            'preferences.seller_delivery' => 'nullable|boolean',
            'preferences.platform_delivery' => 'nullable|boolean',
            'preferences.pickup_option' => 'nullable|boolean',
            'preferences.same_day_delivery' => 'nullable|boolean',
            'preferences.express_delivery' => 'nullable|boolean',

            'preferences.delivery_charge' => 'nullable|numeric|min:0|max:1000000',
            'preferences.free_shipping_threshold' => 'nullable|numeric|min:0|max:10000000',
            'preferences.estimated_delivery_days' => 'nullable|integer|min:1|max:365',

            'preferences.auto_accept_orders' => 'nullable|boolean',
            'preferences.allow_order_cancellation' => 'nullable|boolean',
            'preferences.allow_return_requests' => 'nullable|boolean',
            'preferences.allow_exchange_requests' => 'nullable|boolean',
            'preferences.auto_update_order_status' => 'nullable|boolean',

            'preferences.order_confirmation_notification' => 'nullable|boolean',
            'preferences.delivery_status_notification' => 'nullable|boolean',

            'preferences.default_product_status' => 'nullable|in:active,inactive',
            'preferences.default_rating' => 'nullable|numeric|min:0|max:5',
            'preferences.low_stock_threshold' => 'nullable|integer|min:0|max:100000',

            'preferences.allow_customer_reviews' => 'nullable|boolean',
            'preferences.allow_customer_questions' => 'nullable|boolean',
            'preferences.show_stock_quantity' => 'nullable|boolean',
            'preferences.product_visibility_enabled' => 'nullable|boolean',
            'preferences.auto_hide_out_of_stock' => 'nullable|boolean',

            'preferences.profile_visibility' => 'nullable|boolean',
            'preferences.shop_visibility' => 'nullable|boolean',
            'preferences.show_mobile_number' => 'nullable|boolean',
            'preferences.show_email' => 'nullable|boolean',
            'preferences.show_business_information' => 'nullable|boolean',

            'preferences.allow_customer_messages' => 'nullable|boolean',
            'preferences.auto_reply' => 'nullable|boolean',

            'preferences.welcome_message' => 'nullable|string|max:1000',
            'preferences.order_message' => 'nullable|string|max:1000',
            'preferences.cancellation_message' => 'nullable|string|max:1000',
            'preferences.delivery_message' => 'nullable|string|max:1000',

            'preferences.show_seller_logo_on_invoice' => 'nullable|boolean',
            'preferences.show_gst_on_invoice' => 'nullable|boolean',
            'preferences.show_seller_address_on_invoice' => 'nullable|boolean',
            'preferences.show_customer_address_on_invoice' => 'nullable|boolean',
            'preferences.show_payment_details_on_invoice' => 'nullable|boolean',
            'preferences.show_qr_on_invoice' => 'nullable|boolean',

            'preferences.invoice_prefix' => 'nullable|string|max:30',
            'preferences.invoice_footer' => 'nullable|string|max:1000',

            'preferences.store_active' => 'nullable|boolean',
            'preferences.temporarily_closed' => 'nullable|boolean',
            'preferences.vacation_mode' => 'nullable|boolean',
        ]);

        $current = array_merge(
            $this->defaultPreferences(),
            is_array($seller->preferences)
                ? $seller->preferences
                : []
        );

        /*
         * Checkboxes that are unchecked are not submitted by HTML forms.
         * Therefore we explicitly convert every checkbox into 0/1.
         */
        $booleanFields = [
            'shipping_enabled',
            'seller_delivery',
            'platform_delivery',
            'pickup_option',
            'same_day_delivery',
            'express_delivery',

            'auto_accept_orders',
            'allow_order_cancellation',
            'allow_return_requests',
            'allow_exchange_requests',
            'auto_update_order_status',

            'order_confirmation_notification',
            'delivery_status_notification',

            'allow_customer_reviews',
            'allow_customer_questions',
            'show_stock_quantity',
            'product_visibility_enabled',
            'auto_hide_out_of_stock',

            'profile_visibility',
            'shop_visibility',
            'show_mobile_number',
            'show_email',
            'show_business_information',

            'allow_customer_messages',
            'auto_reply',

            'show_seller_logo_on_invoice',
            'show_gst_on_invoice',
            'show_seller_address_on_invoice',
            'show_customer_address_on_invoice',
            'show_payment_details_on_invoice',
            'show_qr_on_invoice',

            'store_active',
            'temporarily_closed',
            'vacation_mode',
        ];

        $incomingPreferences = $validated['preferences'] ?? [];

        foreach ($booleanFields as $field) {
            $incomingPreferences[$field] =
                $request->boolean("preferences.$field");
        }

        /*
         * Keep non-checkbox values.
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

        $preferences = array_merge(
            $current,
            $incomingPreferences
        );

        /*
         * Store logic:
         * Vacation mode or temporary close means store is effectively closed.
         */
        if (
            $preferences['vacation_mode'] ||
            $preferences['temporarily_closed']
        ) {
            $preferences['store_active'] = false;
        }

        $seller->update([
            'theme' => $validated['theme'],
            'notifications_enabled' =>
                $request->boolean('notifications_enabled'),
            'online_payments_enabled' =>
                $request->boolean('online_payments_enabled'),
            'preferences' => $preferences,
        ]);

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

        $seller->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

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
        ]);

        if ($seller->payment_qr) {
            $oldPath = ltrim(
                $seller->payment_qr,
                '/'
            );

            if (str_starts_with(
                $oldPath,
                'storage/'
            )) {
                $oldPath = substr(
                    $oldPath,
                    strlen('storage/')
                );
            }

            Storage::disk('public')->delete(
                $oldPath
            );
        }

        $path = $validated['payment_qr']->store(
            'seller-payment-qr',
            'public'
        );

        $seller->update([
            'payment_qr' => $path,
        ]);

        return back()->with(
            'success',
            'Payment QR updated successfully.'
        );
    }

    /**
     * Delete payment QR.
     */
    public function deletePaymentQr()
    {
        $seller = $this->currentSeller();

        if ($seller->payment_qr) {
            $oldPath = ltrim(
                $seller->payment_qr,
                '/'
            );

            if (str_starts_with(
                $oldPath,
                'storage/'
            )) {
                $oldPath = substr(
                    $oldPath,
                    strlen('storage/')
                );
            }

            Storage::disk('public')->delete(
                $oldPath
            );
        }

        $seller->update([
            'payment_qr' => null,
        ]);

        return back()->with(
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
            'shipping_enabled' => true,
            'seller_delivery' => true,
            'platform_delivery' => false,
            'pickup_option' => false,
            'same_day_delivery' => false,
            'express_delivery' => false,

            'delivery_charge' => 0,
            'free_shipping_threshold' => 0,
            'estimated_delivery_days' => 3,

            'auto_accept_orders' => false,
            'allow_order_cancellation' => true,
            'allow_return_requests' => true,
            'allow_exchange_requests' => false,
            'auto_update_order_status' => false,

            'order_confirmation_notification' => true,
            'delivery_status_notification' => true,

            'default_product_status' => 'active',
            'default_rating' => 4.5,
            'low_stock_threshold' => 5,

            'allow_customer_reviews' => true,
            'allow_customer_questions' => true,
            'show_stock_quantity' => true,
            'product_visibility_enabled' => true,
            'auto_hide_out_of_stock' => false,

            'profile_visibility' => true,
            'shop_visibility' => true,
            'show_mobile_number' => false,
            'show_email' => false,
            'show_business_information' => true,

            'allow_customer_messages' => true,
            'auto_reply' => false,

            'welcome_message' => '',
            'order_message' => '',
            'cancellation_message' => '',
            'delivery_message' => '',

            'show_seller_logo_on_invoice' => true,
            'show_gst_on_invoice' => true,
            'show_seller_address_on_invoice' => true,
            'show_customer_address_on_invoice' => true,
            'show_payment_details_on_invoice' => true,
            'show_qr_on_invoice' => false,

            'invoice_prefix' => 'SB-',
            'invoice_footer' => '',

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

        return SellerProfile::findOrFail(
            $sellerId
        );
    }
}
