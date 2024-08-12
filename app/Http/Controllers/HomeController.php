<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 評価が高い店舗を取得
        $highly_rated_restaurants = Restaurant::withAvg('reviews', 'score')
            ->orderBy('reviews_avg_score', 'desc')
            ->take(6)
            ->get();

        // 最新の店舗を取得
        $new_restaurants = Restaurant::orderBy('created_at', 'desc')->take(6)->get();

        // 全カテゴリを取得
        $categories = Category::all();

        // ビューに変数を渡す
        return view('home', [
            'highly_rated_restaurants' => $highly_rated_restaurants,
            'categories' => $categories,
            'new_restaurants' => $new_restaurants,
        ]);
    }
}
