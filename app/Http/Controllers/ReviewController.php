<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller {
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant) {
        return view('reviews.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant) {
        $request->validate([
            'score' => 'required|numeric|between:1,5',
            'comment' => 'required',
        ]);

        $review = new Review();
        $review->score = $request->input('score');
        $review->comment = $request->input('comment');
        $review->restaurant_id = $restaurant->id;
        $review->user_id = Auth::id();
        $review->save();

        return redirect()->route('restaurants.show', $restaurant)->with('flash_message', 'レビューの投稿が完了しました。');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant, Review $review) {
        return view('reviews.edit', compact('restaurant', 'review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant, Review $review) {
        $request->validate([
            'score' => 'required|numeric|between:1,5',
            'comment' => 'required',
        ]);

        $review = new Review();
        $review->score = $request->input('score');
        $review->comment = $request->input('comment');
        $review->restaurant_id = $restaurant->id;
        $review->user_id = Auth::id();
        $review->save();

        return redirect()->route('restaurants.show', $restaurant)->with('flash_message', 'レビューの編集が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, Review $review) {
        $review->delete();

        return redirect()->route('restaurants.show', $restaurant)->with('flash_message', 'レビューの削除が完了しました。');
    }
}
