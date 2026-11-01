<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigurePasskeyOrigin
{
    public function handle(Request $request, Closure $next): Response
    {
        config([
            'passkeys.relying_party_id' => strtolower($request->getHost()),
            'passkeys.allowed_origins' => [$request->getSchemeAndHttpHost()],
        ]);

        return $next($request);
    }
}
