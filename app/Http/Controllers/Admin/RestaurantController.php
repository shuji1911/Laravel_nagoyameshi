<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    {
        return view('admin.restaurants.show', compact('restaurant'));
    }

    // 店舗登録ページ
    public function create(Restaurant $restaurant)
    {
        return view('admin.restaurants.create', compact('restaurant'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $restaurant = new Restaurant($request->except('image'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $filename = basename($path);
            $restaurant->image = $filename;
        } else {
            $restaurant->image = '';
        }

        $restaurant->save();

        return redirect()->route('admin.restaurants.index')
            ->with('flash_message', '店舗を登録しました。');
    }

    // 店舗編集ページ
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $restaurant->fill($request->except('image'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $filename = basename($path);
            $restaurant->image = $filename;
        }

        $restaurant->save();

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
