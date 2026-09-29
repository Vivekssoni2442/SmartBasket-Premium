<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

/** Adapter for an authorized UIDAI/e-KYC provider. It deliberately has no fallback or fake-success path. */
class AadhaarVerificationService
{
    public function configured(): bool { return filled(config('services.aadhaar.provider')) && filled(config('services.aadhaar.base_url')) && filled(config('services.aadhaar.api_key')) && filled(config('services.aadhaar.client_id')) && filled(config('services.aadhaar.client_secret')); }
    public function startVerification(string $identity): array
    {
        if (! $this->configured()) return ['configured' => false];
        $response = Http::baseUrl(rtrim(config('services.aadhaar.base_url'), '/'))->acceptJson()->withToken(config('services.aadhaar.api_key'))->post('/verifications', ['identity' => $identity, 'client_id' => config('services.aadhaar.client_id')]);
        $response->throw(); $data = $response->json();
        return ['configured' => true, 'reference_id' => $data['reference_id'] ?? $data['id'] ?? null];
    }
    public function sendOtp(string $referenceId): array { if (! $this->configured()) return ['configured' => false]; $response = Http::baseUrl(rtrim(config('services.aadhaar.base_url'), '/'))->acceptJson()->withToken(config('services.aadhaar.api_key'))->post("/verifications/{$referenceId}/otp"); $response->throw(); return ['configured' => true]; }
    public function verifyOtp(string $referenceId, string $otp): array { if (! $this->configured()) return ['configured' => false]; $response = Http::baseUrl(rtrim(config('services.aadhaar.base_url'), '/'))->acceptJson()->withToken(config('services.aadhaar.api_key'))->post("/verifications/{$referenceId}/verify", ['otp' => $otp]); $response->throw(); $data = $response->json(); return ['configured' => true, 'verified' => (bool) ($data['verified'] ?? false), 'reference_id' => $data['reference_id'] ?? $referenceId]; }
    public function getVerificationStatus(string $referenceId): array { if (! $this->configured()) return ['configured' => false]; $response = Http::baseUrl(rtrim(config('services.aadhaar.base_url'), '/'))->acceptJson()->withToken(config('services.aadhaar.api_key'))->get("/verifications/{$referenceId}"); $response->throw(); return $response->json(); }
}
