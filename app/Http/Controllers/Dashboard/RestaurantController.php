<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;

class RestaurantController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $restaurants = Restaurant::where('name', 'like', "%{$keyword}%")->paginate(10);
        } else {
            $restaurants = Restaurant::paginate(10);
        }

        return view('dashboard.restaurants.index', compact('restaurants', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::all();
        return view('dashboard.restaurants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'lowest_price' => 'required|numeric|lt:highest_price',
            'highest_price' => 'required|numeric|gt:lowest_price',
            'opening_hour' => 'required|digits_between:1,2|lt:closing_hour',
            'closing_hour' => 'required|digits_between:1,2|gt:opening_hour',
            'postal_code1' => 'required|digits:3',
            'postal_code2' => 'required|digits:4',
            'address' => 'required',
            'phone_number' => 'required',
            'regular_holiday' => 'required',
        ]);

        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($image);
        } else {
            $restaurant->image = '';
        }
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->opening_time = $request->input('opening_hour') . ':' . $request->input('opening_minute');
        $restaurant->closing_time = $request->input('closing_hour') . ':' . $request->input('closing_minute');
        $restaurant->postal_code = $request->input('postal_code1') . $request->input('postal_code2');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->regular_holiday = $request->input('regular_holiday');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->save();

        return redirect()->route('dashboard.restaurants.index')->with('flash_message', '店舗情報を登録しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant) {
        return view('dashboard.restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant) {
        $categories = Category::all();
        return view('dashboard.restaurants.edit', compact('restaurant', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant) {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'lowest_price' => 'required|numeric|lt:highest_price',
            'highest_price' => 'required|numeric|gt:lowest_price',
            'opening_hour' => 'required|digits_between:1,2|lt:closing_hour',
            'closing_hour' => 'required|digits_between:1,2|gt:opening_hour',
            'postal_code1' => 'required|digits:3',
            'postal_code2' => 'required|digits:4',
            'address' => 'required',
            'phone_number' => 'required',
            'regular_holiday' => 'required',
        ]);

        $restaurant->name = $request->input('name');
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($image);
        }
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->opening_time = $request->input('opening_hour') . ':' . $request->input('opening_minute');
        $restaurant->closing_time = $request->input('closing_hour') . ':' . $request->input('closing_minute');
        $restaurant->postal_code = $request->input('postal_code1') . $request->input('postal_code2');
        $restaurant->address = $request->input('address');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->regular_holiday = $request->input('regular_holiday');
        $restaurant->category_id = $request->input('category_id');
        $restaurant->save();

        return redirect()->route('dashboard.restaurants.index')->with('flash_message', '店舗情報を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant) {
        $restaurant->delete();
        return redirect()->route('dashboard.restaurants.index')->with('flash_message', '店舗情報を削除しました。');
    }
}
