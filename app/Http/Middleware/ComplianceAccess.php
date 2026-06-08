<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComplianceAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('compliance.internal_access_key');

        if (blank($key)) {
            abort(503, 'Compliance portal not configured. Set COMPLIANCE_ACCESS_KEY in .env');
        }

        $provided = $request->query('key')
            ?? $request->header('X-Compliance-Key')
            ?? $request->session()->get('compliance_key');

        if (is_string($provided) && hash_equals($key, $provided)) {
            $request->session()->put('compliance_key', $key);

            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
