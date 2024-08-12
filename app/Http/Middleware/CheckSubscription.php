<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle($request, $next, $plan)
    {
        if (Auth::check() && Auth::user()->subscribed($plan)) {
            return $next($request);
        }

        return redirect()->route('home')->with('error_message', 'このページにアクセスするには有料プランへの登録が必要です。');
    }
}