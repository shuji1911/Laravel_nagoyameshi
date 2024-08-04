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
        $sorts = [
            '掲載日が新しい順' => 'created_at desc',
            '価格が安い順' => 'lowest_price asc'
        ];
        $sorted = 'created_at desc';

        // 並べ替え設定
        $sort_query = [];
        if ($request->has('select_sort')) {
            $slices = explode(' ', $request->input('select_sort'));
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->input('select_sort');
        }

        // 基本クエリの作成
        $query = Restaurant::query();

        // キーワード検索
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->whereHas('categories', function ($q) use ($keyword) {
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

        // データの並べ替え
        $restaurants = $query->sortable($sort_query)
                              ->orderByRaw($sorted)
                              ->paginate(15);

        // カテゴリを取得
        $categories = Category::all();

        // 総数の取得
        $total = $restaurants->total();

        return view('restaurants.index', compact('keyword', 'category_id', 'price', 'sorts', 'sorted', 'restaurants', 'categories', 'total'));
    }
    public function show(Restaurant $restaurant)
    {
        return view('restaurants.show', compact('restaurant'));
    }
}
