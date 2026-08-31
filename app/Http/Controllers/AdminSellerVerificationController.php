<?php

namespace App\Http\Controllers;

use App\Mail\SellerApprovedMail;
use App\Mail\SellerApplicationSubmittedMail;
use App\Mail\SellerRejectedMail;
use App\Models\SellerProfile;
use App\Models\SellerVerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminSellerVerificationController extends Controller
{
    private const ADMIN_EMAIL = 'smartbasket2442@gmail.com';

    private const DOCUMENT_FIELDS = [
        'certificate' => 'business_certificate_path',
        'aadhaar'     => 'aadhaar_document_path',
        'pan'         => 'pan_document_path',
        'shop_proof'  => 'shop_proof_path',
        'bank_proof'  => 'bank_proof_path',
    ];

    public function index()
    {
        return view(
            'admin.seller-verifications.index',
            [
                'applications' => SellerProfile::whereIn(
                    'verification_status',
                    [
                        SellerProfile::STATUS_PENDING_REVIEW,
                        SellerProfile::STATUS_APPROVED,
                        SellerProfile::STATUS_REJECTED,
                        SellerProfile::STATUS_ACTIVE,
                    ]
                )
                    ->latest('verification_submitted_at')
                    ->paginate(20),
            ]
        );
    }

    public function show(SellerProfile $seller)
    {
        return view(
            'admin.seller-verifications.show',
            [
                'application' => $seller,
                'history' => SellerVerificationLog::where(
                    'seller_profile_id',
                    $seller->id
                )
                    ->latest()
                    ->get(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SEND APPLICATION EMAIL
    |--------------------------------------------------------------------------
    */

    public function sendApplicationEmail(
        SellerProfile $seller
    ): bool {
        try {

            Mail::to(self::ADMIN_EMAIL)->send(
                new SellerApplicationSubmittedMail($seller)
            );

            return true;

        } catch (\Throwable $e) {

            Log::error(
                'Seller application email failed.',
                [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage(),
                ]
            );

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL ACCEPT
    |--------------------------------------------------------------------------
    */

    public function emailAccept(
        SellerProfile $seller
    ) {
        if (
            !in_array(
                $seller->verification_status,
                [
                    SellerProfile::STATUS_PENDING_REVIEW,
                    SellerProfile::STATUS_APPROVED,
                ],
                true
            )
        ) {
            return response(
                '<h2 style="font-family:Arial">Application already processed.</h2>',
                422
            );
        }

        $from = $seller->verification_status;

        $seller->update([
            'verification_status' => SellerProfile::STATUS_ACTIVE,
            'approved_at' => now(),
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => auth()->id(),
            'rejection_reason' => null,

            'activation_code_hash' => null,
            'activation_code_expires_at' => null,
            'activation_attempts' => 0,
        ]);

        $this->log(
            $seller,
            'accepted_from_email',
            $from
        );

        try {

            Mail::to($seller->email)->send(
                new SellerApprovedMail($seller)
            );

        } catch (\Throwable $e) {

            Log::warning(
                'Seller approval email could not be sent.',
                [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage(),
                ]
            );
        }

        return view(
            'admin.seller-verifications.email-accepted',
            [
                'seller' => $seller,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL REJECT
    |--------------------------------------------------------------------------
    */

    public function emailReject(
        SellerProfile $seller
    ) {
        if (
            !in_array(
                $seller->verification_status,
                [
                    SellerProfile::STATUS_PENDING_REVIEW,
                    SellerProfile::STATUS_APPROVED,
                ],
                true
            )
        ) {
            return response(
                '<h2 style="font-family:Arial">Application already processed.</h2>',
                422
            );
        }

        $from = $seller->verification_status;

        $seller->update([
            'verification_status' => SellerProfile::STATUS_REJECTED,
            'rejection_reason' =>
                'Application rejected by SMART BASKET administrator.',
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => auth()->id(),
        ]);

        $this->log(
            $seller,
            'rejected_from_email',
            $from
        );

        try {

            Mail::to($seller->email)->send(
                new SellerRejectedMail($seller)
            );

        } catch (\Throwable $e) {

            Log::warning(
                'Seller rejection email could not be sent.',
                [
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage(),
                ]
            );
        }

        return view(
            'admin.seller-verifications.email-rejected',
            [
                'seller' => $seller,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMAL ADMIN APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(
        SellerProfile $seller
    ) {
        $application = $seller;
        abort_unless(
            $application->verification_status ===
            SellerProfile::STATUS_PENDING_REVIEW,
            422
        );

        $from = $application->verification_status;

        $application->update([
            'verification_status' => SellerProfile::STATUS_ACTIVE,
            'approved_at' => now(),
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        $this->log(
            $application,
            'approved',
            $from
        );

        try {

            Mail::to($application->email)->send(
                new SellerApprovedMail($application)
            );

        } catch (\Throwable $e) {

            Log::warning(
                'Seller approval email could not be sent.',
                [
                    'seller_id' => $application->id,
                    'error' => $e->getMessage(),
                ]
            );
        }

        return redirect()
            ->route(
                'admin.seller-verifications.show',
                $application
            )
            ->with(
                'success',
                'Seller approved and activated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        SellerProfile $seller
    ) {
        $application = $seller;
        $data = $request->validate([
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        abort_unless(
            in_array(
                $application->verification_status,
                [
                    SellerProfile::STATUS_PENDING_REVIEW,
                    SellerProfile::STATUS_APPROVED,
                ],
                true
            ),
            422
        );

        $from = $application->verification_status;

        $application->update([
            'verification_status' => SellerProfile::STATUS_REJECTED,
            'rejection_reason' => $data['reason'],
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => auth()->id(),
        ]);

        $this->log(
            $application,
            'rejected',
            $from
        );

        try {

            Mail::to($application->email)->send(
                new SellerRejectedMail($application)
            );

        } catch (\Throwable $e) {

            Log::warning(
                'Seller rejection email could not be sent.',
                [
                    'seller_id' => $application->id,
                    'error' => $e->getMessage(),
                ]
            );
        }

        return back()->with(
            'success',
            'Seller application rejected.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENTS
    |--------------------------------------------------------------------------
    */

    public function viewDocument(
        SellerProfile $seller,
        string $type
    ) {
        $path = $this->documentPath(
            $seller,
            $type
        );

        return response()->file(
            Storage::disk('local')->path($path)
        );
    }

    public function downloadDocument(
        SellerProfile $seller,
        string $type
    ) {
        $path = $this->documentPath(
            $seller,
            $type
        );

        return response()->download(
            Storage::disk('local')->path($path),
            $type . '.' . pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    private function documentPath(
        SellerProfile $seller,
        string $type
    ): string {
        abort_unless(
            isset(self::DOCUMENT_FIELDS[$type]),
            404
        );

        $path = $seller->{self::DOCUMENT_FIELDS[$type]};

        abort_unless(
            filled($path),
            404
        );

        abort_unless(
            Storage::disk('local')->exists($path),
            404
        );

        return $path;
    }

    /*
    |--------------------------------------------------------------------------
    | SUSPEND
    |--------------------------------------------------------------------------
    */

    public function suspend(
        SellerProfile $seller
    ) {
        $from = $seller->verification_status;

        $seller->update([
            'verification_status' => SellerProfile::STATUS_SUSPENDED,
            'admin_reviewed_at' => now(),
            'admin_reviewed_by' => auth()->id(),
        ]);

        $this->log(
            $seller,
            'suspended',
            $from
        );

        return back()->with(
            'success',
            'Seller suspended.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOG
    |--------------------------------------------------------------------------
    */

    private function log(
        SellerProfile $seller,
        string $event,
        string $from
    ): void {
        SellerVerificationLog::create([
            'seller_profile_id' => $seller->id,
            'actor_id' => auth()->id(),
            'event' => $event,
            'from_status' => $from,
            'to_status' => $seller->verification_status,
        ]);
    }
}