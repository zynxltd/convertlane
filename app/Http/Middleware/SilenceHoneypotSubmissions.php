<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SilenceHoneypotSubmissions
{
    /** @var list<string> */
    private const TRAP_FIELDS = ['_trap', 'website_hp'];

    public function handle(Request $request, Closure $next): Response
    {
        foreach (self::TRAP_FIELDS as $field) {
            if (filled($request->input($field))) {
                Log::info('Contact form honeypot triggered', [
                    'field' => $field,
                    'ip' => $request->ip(),
                ]);

                return redirect()
                    ->route('contact')
                    ->with('success', 'Message sent. We typically respond within one business day.');
            }
        }

        return $next($request);
    }
}
