<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminOrLaboran
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        if ($user->isAdmin() || $user->isLaboran()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses');
    }
}
