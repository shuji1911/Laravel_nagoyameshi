<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $highly_rated_restaurants = Restaurant::with('reviews')
            ->selectRaw('restaurants.*, AVG(reviews.score) as reviews_avg_score')
            ->leftJoin('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
            ->groupBy('restaurants.id')
            ->orderBy('reviews_avg_score', 'desc')
            ->take(6)
            ->get();
        
        $new_restaurants = Restaurant::orderBy('created_at', 'desc')->take(6)->get();
        $categories = Category::all();

        

        return view('home', [
            'highly_rated_restaurants' => $highly_rated_restaurants,
            'categories' => $categories,
            'new_restaurants' => $new_restaurants,
        ]);
    }
}

