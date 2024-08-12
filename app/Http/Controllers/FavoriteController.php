<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;


class FavoriteController extends Controller
{
    /**
     * お気に入り一覧ページ
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ログイン中のユーザー
        $user = Auth::user();

        // お気に入りの店舗を取得し、ページネーションを適用
        $favorite_restaurants = $user->favorite_restaurants()
            ->orderByPivot('created_at', 'desc')
            ->paginate(15);

        // ビューに渡す
        return view('favorites.index', compact('favorite_restaurants'));
    }

    /**
     * お気に入り追加機能
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function store(Request $request)
    // {
    //      // 店舗IDを取得
    //      $restaurant_id = $request->input('restaurant_id');
    //     //バリデーション
    //     $request->validate([
    //         'restaurant_id' => 'exists:restaurants,id',
    //      ]);
        
    //     // ログイン中のユーザー
    //     $user = Auth::user();

       
        
    //     // お気に入り追加
    //    $user->favorite_restaurants()->attach($restaurant_id);
        
    //     // フラッシュメッセージをセッションに保存
    //     //return redirect()->back()->with('flash_message', 'お気に入りに追加しました。');
    //     //return redirect()->back();
    //     return redirect()->route('favorites.index')->with('flash_message', 'お気に入り追加しました。');
    // }
    public function store(Request $request, $restaurantId)
    {
        // 現在ログイン中のユーザーを取得
        $user = Auth::user();
        
        // 指定された店舗を取得
        $restaurant = Restaurant::findOrFail($restaurantId);
        
        // ユーザーと店舗を紐づける
        $user->favorite_restaurants()->attach($restaurant->id);
        
        // セッションにフラッシュメッセージを設定
        $request->session()->flash('flash_message', 'お気に入りに追加しました。');
        
        // 元のページにリダイレクト
        return redirect()->back();
    }

    /**
     * お気に入り解除機能
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // バリデーション
        // $request->validate([
        //     'restaurant_id' => 'required|exists:restaurants,id',
        // ]);

        // ログイン中のユーザー
        $user = Auth::user();

        // 店舗IDを取得
        $restaurant_id = $request->input('restaurant_id');

        // お気に入り解除
        $user->favorite_restaurants()->detach($restaurant_id);

        // フラッシュメッセージをセッションに保存
        return redirect()->back()->with('flash_message', 'お気に入りを解除しました。');
    }
}

