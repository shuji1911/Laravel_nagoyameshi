<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        // 初期値の設定
        $keyword = $request->input('keyword');
        $category_id = $request->input('category_id');
        $price = $request->input('price');

        // ソートオプション
        $sorts = [
            '掲載日が新しい順' => 'created_at desc',
            '価格が安い順' => 'lowest_price asc',
            '評価が高い順' => 'rating desc',
            '予約数が多い順' => 'popular'
        ];
        $sorted = 'created_at desc';

        // 基本クエリの作成
        $query = Restaurant::query();

        // キーワード検索
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhereHas('categories', function ($q) use ($keyword) {
                      $q->where('categories.name', 'like', "%{$keyword}%");
                  });
            });
        }

        // カテゴリIDによるフィルタリング
        if ($category_id) {
            $query->whereHas('categories', function ($q) use ($category_id) {
                $q->where('categories.id', $category_id);
            });
        }

        // 価格によるフィルタリング
        if ($price) {
            $query->where('lowest_price', '<=', $price);
        }

        // 並べ替え設定
        if ($request->has('select_sort')) {
            $sorted = $request->input('select_sort');

            if ($sorted === 'popular') {
                $query = $query->popularSortable();
            } elseif ($sorted === 'rating desc') {
                $query->ratingSortable('desc');
            } elseif ($sorted === 'rating asc') {
                $query->ratingSortable('asc');
            } else {
                $query->orderByRaw($sorted);
            }
        } else {
            $query->orderByRaw($sorted);
        }

        // 店舗データの取得
        $restaurants = $query->paginate(15);

        // カテゴリを取得
        $categories = Category::all();

        // 総数の取得
        $total = $restaurants->total();

        return view('restaurants.index', compact('keyword', 'category_id', 'price', 'sorts', 'sorted', 'restaurants', 'categories','total'));
    }

    public function show(Restaurant $restaurant)
    {
        // レビューも取得してビューに渡す
        $reviews = $restaurant->reviews()->orderBy('created_at', 'desc')->get();
        session()->flash('message', '登録が完了しました。');
        return view('restaurants.show', compact('restaurant', 'reviews'));
    }
}
