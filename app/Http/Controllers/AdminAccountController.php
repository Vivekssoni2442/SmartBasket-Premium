<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminAuditLog;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminAccountController extends Controller
{
    public function customers(Request $request)
    {
        $query = User::query();
        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }
        if ($request->filled('status')) {
            match ($request->string('status')->toString()) {
                'blocked' => $query->whereNotNull('blocked_at'),
                'active' => $query->whereNull('blocked_at'),
                default => null,
            };
        }
        if ($request->filled('search')) {
            $term = trim((string) $request->input('search'));
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%"));
        }
        $sort = in_array($request->input('sort'), ['name', 'email', 'created_at'], true) ? $request->input('sort') : 'created_at';
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';
        $customers = $query->withCount('orders')->orderBy($sort, $direction)->paginate(20)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function sellers(Request $request)
    {
        $query = SellerProfile::query();
        if ($request->boolean('deleted')) {
            $query->onlyTrashed();
        }
        if ($request->filled('status')) {
            match ($request->string('status')->toString()) {
                'blocked' => $query->whereNotNull('blocked_at'),
                'active' => $query->whereNull('blocked_at'),
                default => null,
            };
        }
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->input('verification_status'));
        }
        if ($request->filled('search')) {
            $term = trim((string) $request->input('search'));
            $query->where(fn ($q) => $q->where('seller_name', 'like', "%{$term}%")
                ->orWhere('shop_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('mobile_number', 'like', "%{$term}%"));
        }

        $sort = in_array($request->input('sort'), ['seller_name', 'email', 'created_at', 'verification_status'], true) ? $request->input('sort') : 'created_at';
        $direction = $request->input('direction') === 'asc' ? 'asc' : 'desc';
        $sellers = $query->orderBy($sort, $direction)->paginate(20)->withQueryString();
        $sellerStats = [
            'total' => SellerProfile::count(),
            'approved' => SellerProfile::whereIn('verification_status', [SellerProfile::STATUS_APPROVED, SellerProfile::STATUS_ACTIVE])->count(),
            'pending' => SellerProfile::whereIn('verification_status', [SellerProfile::STATUS_PENDING_ADMIN_REVIEW, SellerProfile::STATUS_UNDER_REVIEW])->count(),
            'rejected' => SellerProfile::where('verification_status', SellerProfile::STATUS_REJECTED)->count(),
            'suspended' => SellerProfile::where('verification_status', SellerProfile::STATUS_SUSPENDED)->count(),
        ];

        return view('admin.sellers.index', compact('sellers', 'sellerStats'));
    }

    public function blockCustomer(Request $request, User $user)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'min:3', 'max:500']]);
        DB::transaction(function () use ($request, $user, $data) {
            if (! $user->isBlocked()) {
                $user->forceFill(['blocked_at' => now(), 'block_reason' => $data['reason'], 'remember_token' => \Illuminate\Support\Str::random(60)])->save();
                if (DB::getSchemaBuilder()->hasTable('sessions')) {
                    DB::table('sessions')->where('user_id', $user->id)->delete();
                }
                $this->audit('customer.block', 'customer', $user->id, 'Blocked customer account.', null, ['reason' => $data['reason']]);
            }
        });
        return back()->with('success', 'Customer account blocked.');
    }

    public function unblockCustomer(User $user)
    {
        DB::transaction(function () use ($user) {
            if ($user->isBlocked()) {
                $oldReason = $user->block_reason;
                $user->forceFill(['blocked_at' => null, 'block_reason' => null])->save();
                $this->audit('customer.unblock', 'customer', $user->id, 'Unblocked customer account.', ['reason' => $oldReason], null);
            }
        });
        return back()->with('success', 'Customer account unblocked.');
    }

    public function blockSeller(Request $request, SellerProfile $seller)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'min:3', 'max:500']]);
        DB::transaction(function () use ($seller, $data) {
            if (! $seller->isBlocked()) {
                $seller->forceFill(['blocked_at' => now(), 'block_reason' => $data['reason']])->save();
                $this->audit('seller.block', 'seller', $seller->id, 'Blocked seller account.', null, ['reason' => $data['reason']]);
            }
        });
        return back()->with('success', 'Seller account blocked.');
    }

    public function unblockSeller(SellerProfile $seller)
    {
        DB::transaction(function () use ($seller) {
            if ($seller->isBlocked()) {
                $oldReason = $seller->block_reason;
                $seller->forceFill(['blocked_at' => null, 'block_reason' => null])->save();
                $this->audit('seller.unblock', 'seller', $seller->id, 'Unblocked seller account.', ['reason' => $oldReason], null);
            }
        });
        return back()->with('success', 'Seller account unblocked.');
    }

    public function deleteCustomer(Request $request, User $user)
    {
        $this->authorizeDeletion($request);
        $this->confirmDeletion($request);
        DB::transaction(function () use ($user) {
            $user->delete(); // Soft delete preserves orders, payments and related history.
            $this->audit('customer.deactivate', 'customer', $user->id, 'Soft-deleted customer account; historical records retained.', null, ['deleted_at' => $user->deleted_at?->toISOString()]);
        });
        return redirect()->route('admin.customers.index')->with('success', 'Customer account deactivated; historical records were retained.');
    }

    public function deleteSeller(Request $request, SellerProfile $seller)
    {
        $this->authorizeDeletion($request);
        $this->confirmDeletion($request);
        DB::transaction(function () use ($seller) {
            $seller->delete(); // Preserve products, orders, payouts and financial history.
            $this->audit('seller.deactivate', 'seller', $seller->id, 'Soft-deleted seller account; products and historical records retained.', null, ['deleted_at' => $seller->deleted_at?->toISOString()]);
        });
        return redirect()->route('admin.sellers.index')->with('success', 'Seller account deactivated; products and historical records were retained.');
    }

    public function restoreCustomer(Request $request, int $id)
    {
        $admin = Admin::find(session('admin_id'));
        abort_unless($admin && $admin->isSuperAdmin(), 403);
        $customer = User::onlyTrashed()->findOrFail($id);
        DB::transaction(function () use ($customer) {
            $customer->restore();
            $this->audit('customer.restore', 'customer', $customer->id, 'Restored deactivated customer account.', null, ['deleted_at' => null]);
        });
        return back()->with('success', 'Customer account restored.');
    }

    public function restoreSeller(Request $request, int $id)
    {
        $admin = Admin::find(session('admin_id'));
        abort_unless($admin && $admin->isSuperAdmin(), 403);
        $seller = SellerProfile::onlyTrashed()->findOrFail($id);
        DB::transaction(function () use ($seller) {
            $seller->restore();
            $this->audit('seller.restore', 'seller', $seller->id, 'Restored deactivated seller account.', null, ['deleted_at' => null]);
        });
        return back()->with('success', 'Seller account restored.');
    }

    private function authorizeDeletion(Request $request): void
    {
        $admin = Admin::find(session('admin_id'));
        abort_unless($admin && $admin->isSuperAdmin(), 403, 'Only a super administrator can deactivate accounts.');
    }

    private function confirmDeletion(Request $request): void
    {
        $request->validate(['confirmation' => ['required', 'in:DELETE']]);
    }

    private function audit(string $action, string $type, int|string $id, string $description, ?array $old, ?array $new): void
    {
        $admin = Admin::find(session('admin_id'));
        if (! $admin) {
            throw ValidationException::withMessages(['admin' => 'Administrator session is no longer valid.']);
        }
        AdminAuditLog::log($admin, $action, $type, (string) $id, $description, $old, $new);
    }
}
