<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckNotSubscribed
{
    public function handle($request, Closure $next, $plan)
    {
        if (Auth::check() && !Auth::user()->subscribed($plan)) {
            return $next($request);
        }

        return redirect()->route('home')->with('flash_message', 'サブスクリプションにアクセスするには、プランに登録する必要があります。');
    }
}

