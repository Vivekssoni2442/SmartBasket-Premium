<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellerFaceUnlockController extends Controller
{
    public function challenge(Request $request): RedirectResponse|\Illuminate\Contracts\View\View
    {
        $sellerId = (int) $request->session()->get('seller_face_pending_id', 0);
        $seller = $sellerId ? SellerProfile::find($sellerId) : null;

        if (! $seller || $seller->isBlocked() || ! $seller->face_unlock_enabled || ! $seller->hasPasskeysEnabled()) {
            $request->session()->forget('seller_face_pending_id');
            return redirect()->route('seller.login')->with('error', 'Face unlock could not be started. Please sign in again or contact support.');
        }

        return view('auth.seller-face-unlock', compact('seller'));
    }

    public function enable(Request $request): JsonResponse
    {
        $seller = $this->currentSeller($request);
        abort_unless($seller->hasPasskeysEnabled(), 422, 'Register a device face-unlock key first.');

        $seller->forceFill(['face_unlock_enabled' => true])->save();

        return response()->json(['ok' => true, 'enabled' => true]);
    }

    public function disable(Request $request): JsonResponse
    {
        $seller = $this->currentSeller($request);
        $seller->forceFill(['face_unlock_enabled' => false])->save();

        return response()->json(['ok' => true, 'enabled' => false]);
    }

    private function currentSeller(Request $request): SellerProfile
    {
        $seller = SellerProfile::findOrFail((int) $request->session()->get('seller_id'));
        abort_if($seller->isBlocked(), 403);

        return $seller;
    }
}
