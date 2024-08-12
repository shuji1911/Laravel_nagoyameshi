<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $plan
     * @return mixed
     */
    public function handle($request, Closure $next, $plan)
    {
        // 現在ログイン中のユーザーを取得
        $user = Auth::user();

        // ユーザーが指定したプランにサブスクリプションしているか確認
        if ($user && $user->subscribed($plan)) {
            // サブスクリプションがある場合、リダイレクト
            return redirect('subscription/edit');
        }

        return $next($request);
    }
}
