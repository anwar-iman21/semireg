<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('admin_authenticated')) {
            return redirect()->to(route('admin.login', [], false))
                ->with('error', 'Silakan masuk sebagai panitia terlebih dahulu.');
        }

        return $next($request);
    }
}
