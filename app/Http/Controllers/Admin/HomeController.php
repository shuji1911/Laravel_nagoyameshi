<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Category モデルをインポート

class HomeController extends Controller
{
    public function index()
    {
        // カテゴリの取得
        $categories = Category::all(); // 必要に応じて条件を指定

        // ビューに渡す
        return view('home', compact('categories'));
    }
}
