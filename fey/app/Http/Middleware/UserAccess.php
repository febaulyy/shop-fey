<?php

namespace App\Http\Middleware;
namespace Database\Seeders;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        return redirect('/home')->with('error', "Kamu tidak punya akses ke halaman ini.");
    }
}
