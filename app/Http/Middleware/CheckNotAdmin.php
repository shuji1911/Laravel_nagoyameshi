<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckNotAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error_message', 'このページにアクセスするには管理者権限が必要です。');
        }

        return $next($request);
    }
}

