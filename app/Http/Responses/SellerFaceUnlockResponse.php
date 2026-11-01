<?php

namespace App\Http\Responses;

use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse as PasskeyLoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class SellerFaceUnlockResponse implements PasskeyLoginResponseContract
{
    public function toResponse($request): Response
    {
        abort_unless($request instanceof Request, 403);

        $seller = Auth::guard('seller')->user();
        abort_unless(
            $seller instanceof SellerProfile
                && (int) $request->session()->get('seller_face_pending_id', 0) === (int) $seller->id
                && $seller->face_unlock_enabled
                && ! $seller->isBlocked()
                && ! $seller->trashed(),
            403,
        );

        $request->session()->put([
            'seller_login' => true,
            'seller_email' => $seller->email,
            'seller_id' => $seller->id,
            'seller_face_unlocked_at' => now()->timestamp,
        ]);
        $request->session()->forget('seller_face_pending_id');

        $route = $seller->isApproved() || $seller->isActive()
            ? 'seller.dashboard'
            : ($seller->isApplicationSubmitted() || $seller->isRejected() || $seller->isSuspended()
                ? 'seller.verification.status'
                : 'seller.verification.index');

        return new JsonResponse(['redirect' => route($route)]);
    }
}
