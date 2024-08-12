<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // この行が必要
use App\Models\RegularHoliday; // 追加
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    // 店舗一覧ページ
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $query = Restaurant::query();

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $restaurants = $query->paginate(10);
        $total = $query->count();

        return view('admin.restaurants.index', compact('restaurants', 'keyword', 'total'));
    }

    // 店舗詳細ページ
    public function show(Restaurant $restaurant)
    {// 店舗の定休日を取得
    $regular_holidays = $restaurant->regularHolidays;

    // ビューに店舗と定休日の情報を渡す
    return view('admin.restaurants.show', compact('restaurant', 'regular_holidays'));
}

    // 店舗登録ページ
    public function create()
    {
        // カテゴリーデータを全て取得
    $categories = Category::all();
    // 定休日データを全て取得
    $regular_holidays = RegularHoliday::all();

    // ビューにカテゴリーデータを渡して表示
    return view('admin.restaurants.create', compact('categories', 'regular_holidays'));
    }

    // 店舗登録機能
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
        'description' => 'required|string',
        'lowest_price' => 'required|numeric|min:0|lte:highest_price',
        'highest_price' => 'required|numeric|min:0|gte:lowest_price',
        'postal_code' => 'required|digits:7',
        'address' => 'required|string',
        'opening_time' => 'required|date_format:H:i|before:closing_time',
        'closing_time' => 'required|date_format:H:i|after:opening_time',
        'seating_capacity' => 'required|numeric|min:0',
        'category_ids' => 'array', // カテゴリIDの配列を検証
        'category_ids.*' => 'integer|exists:categories,id', // 各IDがカテゴリテーブルに存在するか確認
        'regular_holiday_ids' => 'array', // 定休日IDの配列を検証
        'regular_holiday_ids.*' => 'integer|exists:regular_holidays,id', // 各IDが定休日テーブルに存在するか確認
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $restaurant = new Restaurant($request->except('image', 'category_ids', 'regular_holiday_ids'));

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/restaurants');
        $filename = basename($path);
        $restaurant->image = $filename;
    } else {
        $restaurant->image = '';
    }

    $restaurant->save();

    // カテゴリIDの取得とフィルタリング
    $category_ids = array_filter($request->input('category_ids', []));
    $regular_holiday_ids = array_filter($request->input('regular_holiday_ids', []));

    // 中間テーブルにカテゴリと定休日を同期
    $restaurant->categories()->sync($category_ids);
    $restaurant->regularHolidays()->sync($regular_holiday_ids);

    return redirect()->route('admin.restaurants.index')
        ->with('flash_message', '店舗を登録しました。');
}

    // 店舗編集ページ
    public function edit(Restaurant $restaurant)
    {
         // カテゴリーデータを全て取得
    $categories = Category::all();
    // 定休日データを全て取得
    $regular_holidays = RegularHoliday::all();
    
    // 店舗に設定されたカテゴリIDの取得
    $category_ids = $restaurant->categories->pluck('id')->toArray();
    // 店舗に設定された定休日IDの取得
    $regular_holiday_ids = $restaurant->regularHolidays->pluck('id')->toArray();

    // ビューにデータを渡して表示
    return view('admin.restaurants.edit', compact('restaurant', 'categories', 'regular_holidays', 'category_ids', 'regular_holiday_ids'));
}

    // 店舗更新機能
    public function update(Request $request, Restaurant $restaurant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'lowest_price' => 'required|numeric|min:0|lte:highest_price',
            'highest_price' => 'required|numeric|min:0|gte:lowest_price',
            'postal_code' => 'required|digits:7',
            'address' => 'required|string',
            'opening_time' => 'required|date_format:H:i|before:closing_time',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'seating_capacity' => 'required|numeric|min:0',
            'category_ids' => 'nullable|array', // 配列が null　でも可
            'category_ids.*' => 'integer|exists:categories,id',
            'regular_holiday_ids' => 'nullable|array', // 配列が null でも許可
            'regular_holiday_ids.*' => 'integer|exists:regular_holidays,id',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // 入力データのフィルタリング
        $data = $request->except('image');
        $restaurant->fill($data);
    
        // 画像の処理
        if ($request->hasFile('image')) {
            // 既存の画像を削除する処理（オプション）
            if ($restaurant->image && file_exists(storage_path('app/public/restaurants/' . $restaurant->image))) {
                unlink(storage_path('app/public/restaurants/' . $restaurant->image));
            }
    
            // 新しい画像の保存
            $path = $request->file('image')->store('public/restaurants');
            $filename = basename($path);
            $restaurant->image = $filename;
        }
    
        $restaurant->save();
    
        // カテゴリIDと定休日IDの取得とフィルタリング
        $category_ids = array_filter($request->input('category_ids', []));
        $regular_holiday_ids = array_filter($request->input('regular_holiday_ids', []));
    
        // 中間テーブルにカテゴリと定休日を同期
        $restaurant->categories()->sync($category_ids);
        $restaurant->regularHolidays()->sync($regular_holiday_ids);
    
        return redirect()->route('admin.restaurants.show', $restaurant)
            ->with('flash_message', '店舗を編集しました。');
    }
    
    // 店舗削除機能
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')
            ->with('flash_message', '店舗を削除しました。');
    }
}
