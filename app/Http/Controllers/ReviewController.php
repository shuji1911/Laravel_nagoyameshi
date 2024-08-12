<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function index(Restaurant $restaurant) {
        $user = Auth::user();
        $reviewsQuery = $restaurant->reviews()->orderBy('created_at', 'desc');

        // プレミアムプランユーザーに対してページネーションの件数を変更
        $reviews = $user && $user->subscribed('premium_plan')
            ? $reviewsQuery->paginate(5)
            : $reviewsQuery->paginate(3); // 通常ユーザーは3件のページネーション

        return view('reviews.index', compact('restaurant', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant) {
        return view('reviews.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant) {
        // バリデーションルールの設定
        $validatedData = $request->validate([
            'score' => 'required|numeric|between:1,5',
            'content' => 'required|string',
        ]);

        $review = new Review();
        $review->score = $validatedData['score'];
        $review->content = $validatedData['content'];
        $review->restaurant_id = $restaurant->id;
        $review->user_id = Auth::id();
        $review->save();

        return redirect()->route('restaurants.reviews.index', $restaurant->id)
                         ->with('flash_message', 'レビューの投稿が完了しました。');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant, Review $review) {
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.reviews.index', $restaurant->id)
                             ->with('error_message', '不正なアクセスです。');
        }

        return view('reviews.edit', compact('restaurant', 'review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant, Review $review) {
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.reviews.index', $restaurant->id)
                             ->with('error_message', '不正なアクセスです。');
        }

        // バリデーションルールの設定
        $validatedData = $request->validate([
            'score' => 'required|numeric|between:1,5',
            'content' => 'required|string',
        ]);

        $review->score = $validatedData['score'];
        $review->content = $validatedData['content'];
        $review->save();

        return redirect()->route('restaurants.reviews.index', $restaurant->id)
                         ->with('flash_message', 'レビューの編集が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, Review $review) {
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.reviews.index', $restaurant->id)
                             ->with('error_message', '不正なアクセスです。');
        }

        $review->delete();

        return redirect()->route('restaurants.reviews.index', $restaurant->id)
                         ->with('flash_message', 'レビューの削除が完了しました。');
    }
}
