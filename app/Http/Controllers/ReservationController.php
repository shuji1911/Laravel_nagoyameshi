<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $reservations = Auth::user()->reservations()->orderBy('reservation_datetime', 'desc')->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request, Restaurant $restaurant) {
        $reservation = new Reservation();
        $reservation->reservation_datetime = $request->input('reservation_datetime');
        $reservation->number_of_people = $request->input('number_of_people');
        $reservation->restaurant_id = $restaurant->id;
        $reservation->user_id = Auth::id();
        $reservation->save();

        return redirect()->route('restaurants.show', $restaurant)->with('flash_message', '店舗の予約が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation) {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('flash_message', '店舗の予約をキャンセルしました。');
    }
}
