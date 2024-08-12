<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category; // Category モデルをインポート
use Illuminate\Support\Facades\DB; // DBクエリビルダをインポート

class HomeController extends Controller
{
    public function index()
    {
        // ユーザー数の取得
        $total_users = DB::table('users')->count();
        
        // 有料会員数の取得
        $total_premium_users = DB::table('subscriptions')
            ->where('stripe_status', 'active')
            ->count();
        
        // 無料会員数の計算
        $total_free_users = $total_users - $total_premium_users;
        
        // レストラン数の取得
        $total_restaurants = DB::table('restaurants')->count();
        
        // 予約数の取得
        $total_reservations = DB::table('reservations')->count();
        
        // 月間売上の計算
        $sales_for_this_month = $total_premium_users * 300;
        
        // ビューに渡す変数をまとめる
        $data = compact(
            'total_users',
            'total_premium_users',
            'total_free_users',
            'total_restaurants',
            'total_reservations',
            'sales_for_this_month'
        );
        
        // カテゴリの取得
        $categories = Category::all(); // 必要に応じて条件を指定
        
        // ビューに渡す
        return view('admin.home', $data)->with('categories', $categories);
    }
}

