<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Jika user mencoba akses admin akan mengembalikan ke dashboard dengan pesan error
        if (Auth::user()->usertype != 'admin') {
            return redirect('/')->with('error', 'You are not allowed to access this page');
        }

        return $next($request);
    }
}
