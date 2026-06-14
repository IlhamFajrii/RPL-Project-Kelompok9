<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlacklist
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->isBlacklisted()) {
            return redirect('/')->with('error', 'Akses ditolak: Anda tidak dapat melakukan peminjaman karena masuk dalam daftar blacklist');
        }

        return $next($request);
    }
}
