<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('cms.access_key');

        if (blank($key)) {
            abort(503, 'CMS not configured. Set CMS_ACCESS_KEY in .env');
        }

        $provided = $request->query('key')
            ?? $request->header('X-Cms-Key')
            ?? $request->session()->get('cms_key');

        if (is_string($provided) && hash_equals($key, $provided)) {
            $request->session()->put('cms_key', $key);

            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
