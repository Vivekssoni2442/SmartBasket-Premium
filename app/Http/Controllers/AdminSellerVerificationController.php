<?php

namespace App\Http\Controllers;

use App\Mail\SellerApprovedMail;
use App\Mail\SellerApplicationSubmittedMail;
use App\Mail\SellerRejectedMail;
use App\Models\Admin;
use App\Models\AdminAuditLog;
use App\Models\SellerProfile;
use App\Models\SellerVerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminSellerVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN EMAIL
    |--------------------------------------------------------------------------
    */

    private const ADMIN_EMAIL = 'smartbasket2442@gmail.com';

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT FIELDS
    |--------------------------------------------------------------------------
    |
    | These are the actual SellerProfile database columns used for
    | seller verification documents.
    |
    */

    private const DOCUMENT_FIELDS = [
        'certificate' => 'business_certificate_path',
        'aadhaar'    => 'aadhaar_document_path',
        'pan'        => 'pan_document_path',
        'shop_proof' => 'shop_proof_path',
        'bank_proof' => 'bank_proof_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Admin seller verification listing.
    |
    | IMPORTANT:
    | The actual database column is:
    |
    | application_submitted_at
    |
    | NOT:
    |
    | verification_submitted_at
    |
    */

    public function index()
    {
        $statuses = [
            SellerProfile::STATUS_PENDING_REVIEW,
            SellerProfile::STATUS_SUBMITTED,
            SellerProfile::STATUS_UNDER_REVIEW,
            SellerProfile::STATUS_APPROVED,
            SellerProfile::STATUS_REJECTED,
            SellerProfile::STATUS_ACTIVE,
        ];

        $applications = SellerProfile::query()
            ->whereIn('verification_status', $statuses)
            ->orderByDesc('application_submitted_at')
            ->paginate(20);

        return view(
            'admin.seller-verifications.index',
            [
                'applications' => $applications,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(SellerProfile $seller)
    {
        $logs = SellerVerificationLog::query()
            ->where(
                'seller_profile_id',
                $seller->id
            )
            ->orderByDesc('created_at')
            ->get();

        return view(
            'admin.seller-verifications.show',
            [
                'seller' => $seller,
                'logs' => $logs,
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
                    SellerProfile::STATUS_SUBMITTED,
                    SellerProfile::STATUS_UNDER_REVIEW,
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

        /*
        |--------------------------------------------------------------------------
        | Update approval information
        |--------------------------------------------------------------------------
        */

        $seller->verification_status =
            SellerProfile::STATUS_ACTIVE;

        $seller->approved_at = now();
        $seller->rejected_at = null;
        $seller->rejection_reason = null;
        $seller->is_active = true;

        /*
        | Keep compatibility with installations that contain
        | admin review columns.
        */

        if ($this->hasAttributeColumn('admin_reviewed_at')) {
            $seller->admin_reviewed_at = now();
        }

        if ($this->hasAttributeColumn('admin_reviewed_by')) {
            $seller->admin_reviewed_by = auth()->id();
        }

        /*
        | Clear activation fields only if they exist.
        */

        if ($this->hasAttributeColumn('activation_code_hash')) {
            $seller->activation_code_hash = null;
        }

        if ($this->hasAttributeColumn('activation_code_expires_at')) {
            $seller->activation_code_expires_at = null;
        }

        if ($this->hasAttributeColumn('activation_attempts')) {
            $seller->activation_attempts = 0;
        }

        $seller->save();

        /*
        |--------------------------------------------------------------------------
        | Verification Log
        |--------------------------------------------------------------------------
        */

        $this->log(
            $seller,
            'accepted_from_email',
            $from
        );

        /*
        |--------------------------------------------------------------------------
        | Seller Approval Email
        |--------------------------------------------------------------------------
        */

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
                    SellerProfile::STATUS_SUBMITTED,
                    SellerProfile::STATUS_UNDER_REVIEW,
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

        $seller->verification_status =
            SellerProfile::STATUS_REJECTED;

        $seller->rejection_reason =
            'Application rejected by SMART BASKET administrator.';

        $seller->is_active = false;

        if ($this->hasAttributeColumn('admin_reviewed_at')) {
            $seller->admin_reviewed_at = now();
        }

        if ($this->hasAttributeColumn('admin_reviewed_by')) {
            $seller->admin_reviewed_by = auth()->id();
        }

        $seller->save();

        /*
        |--------------------------------------------------------------------------
        | Verification Log
        |--------------------------------------------------------------------------
        */

        $this->log(
            $seller,
            'rejected_from_email',
            $from
        );

        /*
        |--------------------------------------------------------------------------
        | Seller Rejection Email
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Already Active
        |--------------------------------------------------------------------------
        */

        if (
            $application->verification_status ===
            SellerProfile::STATUS_ACTIVE
        ) {
            return redirect()
                ->route(
                    'admin.seller-verifications.show',
                    [
                        'seller' => $application->id,
                    ]
                )
                ->with(
                    'success',
                    'Seller is already approved and active.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Current Status
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $application->verification_status,
                [
                    SellerProfile::STATUS_PENDING_REVIEW,
                    SellerProfile::STATUS_SUBMITTED,
                    SellerProfile::STATUS_UNDER_REVIEW,
                    SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
                ],
                true
            )
        ) {
            return redirect()
                ->route(
                    'admin.seller-verifications.show',
                    [
                        'seller' => $application->id,
                    ]
                )
                ->with(
                    'error',
                    'Seller cannot be approved from the current verification status.'
                );
        }

        $from = $application->verification_status;

        /*
        |--------------------------------------------------------------------------
        | Approve Seller
        |--------------------------------------------------------------------------
        */

        $application->verification_status =
            SellerProfile::STATUS_ACTIVE;

        $application->approved_at = now();
        $application->rejected_at = null;
        $application->rejection_reason = null;
        $application->is_active = true;

        /*
        |--------------------------------------------------------------------------
        | Admin Review Compatibility
        |--------------------------------------------------------------------------
        */

        if ($this->hasAttributeColumn('admin_reviewed_at')) {
            $application->admin_reviewed_at = now();
        }

        if ($this->hasAttributeColumn('admin_reviewed_by')) {
            $application->admin_reviewed_by = auth()->id();
        }

        /*
        | Also maintain the fields already present in SellerProfile.
        */

        $application->reviewed_at = now();

        if ($this->hasAttributeColumn('reviewed_by')) {
            $application->reviewed_by = auth()->id();
        }

        $application->save();

        /*
        |--------------------------------------------------------------------------
        | Verification Log
        |--------------------------------------------------------------------------
        */

        $this->log(
            $application,
            'approved',
            $from
        );

        /*
        |--------------------------------------------------------------------------
        | Approval Email
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.seller-verifications.show',
                [
                    'seller' => $application->id,
                ]
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

        /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array(
                $application->verification_status,
                [
                    SellerProfile::STATUS_PENDING_REVIEW,
                    SellerProfile::STATUS_SUBMITTED,
                    SellerProfile::STATUS_UNDER_REVIEW,
                    SellerProfile::STATUS_PENDING_ADMIN_REVIEW,
                    SellerProfile::STATUS_APPROVED,
                ],
                true
            ),
            422
        );

        $from = $application->verification_status;

        /*
        |--------------------------------------------------------------------------
        | Reject Seller
        |--------------------------------------------------------------------------
        */

        $application->verification_status =
            SellerProfile::STATUS_REJECTED;

        $application->rejection_reason =
            $data['reason'];

        $application->is_active = false;

        if ($this->hasAttributeColumn('admin_reviewed_at')) {
            $application->admin_reviewed_at = now();
        }

        if ($this->hasAttributeColumn('admin_reviewed_by')) {
            $application->admin_reviewed_by = auth()->id();
        }

        $application->reviewed_at = now();

        if ($this->hasAttributeColumn('reviewed_by')) {
            $application->reviewed_by = auth()->id();
        }

        $application->save();

        /*
        |--------------------------------------------------------------------------
        | Verification Log
        |--------------------------------------------------------------------------
        */

        $this->log(
            $application,
            'rejected',
            $from
        );

        /*
        |--------------------------------------------------------------------------
        | Rejection Email
        |--------------------------------------------------------------------------
        */

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
    | DOCUMENT VIEW
    |--------------------------------------------------------------------------
    */

    public function viewDocument(
        SellerProfile $seller,
        string $type
    ) {
        [$disk, $path] = $this->documentFile(
            $seller,
            $type
        );

        $fullPath = Storage::disk($disk)->path($path);

        abort_unless(
            is_file($fullPath),
            404
        );

        return response()->file(
            $fullPath
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT DOWNLOAD
    |--------------------------------------------------------------------------
    */

    public function downloadDocument(
        SellerProfile $seller,
        string $type
    ) {
        [$disk, $path] = $this->documentFile(
            $seller,
            $type
        );

        $fullPath = Storage::disk($disk)->path($path);

        abort_unless(
            is_file($fullPath),
            404
        );

        $extension = pathinfo(
            $path,
            PATHINFO_EXTENSION
        );

        $filename = $type;

        if ($extension !== '') {
            $filename .= '.' . $extension;
        }

        return response()->download(
            $fullPath,
            $filename
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT FILE RESOLVER
    |--------------------------------------------------------------------------
    */

    private function documentFile(
        SellerProfile $seller,
        string $type
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Validate Document Type
        |--------------------------------------------------------------------------
        */

        abort_unless(
            array_key_exists(
                $type,
                self::DOCUMENT_FIELDS
            ),
            404
        );

        $field = self::DOCUMENT_FIELDS[$type];

        /*
        |--------------------------------------------------------------------------
        | Check Field Exists
        |--------------------------------------------------------------------------
        */

        $path = $seller->{$field} ?? null;

        abort_unless(
            filled($path),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Try Public Disk
        |--------------------------------------------------------------------------
        */

        if (
            Storage::disk('public')->exists($path)
        ) {
            return [
                'public',
                $path,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Try Local Disk
        |--------------------------------------------------------------------------
        */

        if (
            Storage::disk('local')->exists($path)
        ) {
            return [
                'local',
                $path,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Not Found
        |--------------------------------------------------------------------------
        */

        abort(404);
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

        /*
        |--------------------------------------------------------------------------
        | Update Seller
        |--------------------------------------------------------------------------
        */

        $seller->verification_status =
            SellerProfile::STATUS_SUSPENDED;

        $seller->is_active = false;

        if ($this->hasAttributeColumn('admin_reviewed_at')) {
            $seller->admin_reviewed_at = now();
        }

        if ($this->hasAttributeColumn('admin_reviewed_by')) {
            $seller->admin_reviewed_by = auth()->id();
        }

        $seller->save();

        /*
        |--------------------------------------------------------------------------
        | Verification Log
        |--------------------------------------------------------------------------
        */

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
    | VERIFICATION LOG
    |--------------------------------------------------------------------------
    */

    private function log(
        SellerProfile $seller,
        string $event,
        string $from
    ): void {
        try {
            SellerVerificationLog::create([
                'seller_profile_id' => $seller->id,
                'actor_id' => auth()->id(),
                'event' => $event,
                'from_status' => $from,
                'to_status' => $seller->verification_status,
            ]);
        } catch (\Throwable $e) {
            Log::warning(
                'Seller verification log could not be created.',
                [
                    'seller_id' => $seller->id,
                    'event' => $event,
                    'error' => $e->getMessage(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Audit Log
        |--------------------------------------------------------------------------
        */

        try {
            $admin = Admin::find(
                session('admin_id')
            );

            if ($admin) {
                AdminAuditLog::log(
                    $admin,
                    'seller_' . $event,
                    'SellerProfile',
                    (string) $seller->id,
                    "Seller verification changed from {$from} to {$seller->verification_status}",
                    [
                        'verification_status' => $from,
                    ],
                    [
                        'verification_status' =>
                            $seller->verification_status,
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::warning(
                'Admin seller verification audit log failed.',
                [
                    'seller_id' => $seller->id,
                    'event' => $event,
                    'error' => $e->getMessage(),
                ]
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | OPTIONAL COLUMN CHECK
    |--------------------------------------------------------------------------
    |
    | Some older SmartBasket database versions may contain additional
    | admin-review columns while newer versions use reviewed_at/reviewed_by.
    |
    | This prevents unnecessary failures when an optional column is absent.
    |
    */

    private function hasAttributeColumn(
        string $column
    ): bool {
        try {
            return array_key_exists(
                $column,
                (new SellerProfile)->getAttributes()
            ) || in_array(
                $column,
                (new SellerProfile)->getFillable(),
                true
            );
        } catch (\Throwable) {
            return false;
        }
    }
}