<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses');
    }
}
