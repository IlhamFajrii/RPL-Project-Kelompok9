<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLaboran
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (auth()->user()->isLaboran()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Hanya laboran yang dapat mengakses');
    }
}
