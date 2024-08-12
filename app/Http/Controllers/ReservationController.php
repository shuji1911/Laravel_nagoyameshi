<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'subscribed:premium_plan']);
    }

    // 予約一覧ページ
    public function index()
    {
        $reservations = Auth::user()->reservations()->orderBy('reserved_datetime', 'desc')->paginate(15);
        return view('reservations.index', compact('reservations'));
    }

    // 予約ページ
    public function create(Restaurant $restaurant)
    {
        return view('reservations.create', compact('restaurant'));
    }

    // 予約機能
    public function store(Request $request, Restaurant $restaurant)
    {
        $validatedData = $request->validate([
            'reservation_date' => 'required|date_format:Y-m-d',
            'reservation_time' => 'required|date_format:H:i',
            // 'number_of_people' => 'required|integer|min:1|max:50',
            'number_of_people' => 'required',
        ]);
        //ddd($request->input('number_of_people'));
        $re = new Reservation;
        $re->user_id = Auth::id();
        $re->reserved_datetime = $request->input("reservation_date");
        $re->restaurant_id = $request->input("restaurant_id");
        $re->number_of_people = $request->input("number_of_people");;
        $re->save();
        // Reservation::create([
        //     'reserved_datetime' => "{$validatedData['reservation_date']} {$validatedData['reservation_time']}",
        //     'number_of_people' => 10,//$validatedData['number_of_people'],
        //     'restaurant_id' => $restaurant->id,
        //     'user_id' => Auth::id(),
        // ]);

        return redirect()->route('reservations.index')->with('flash_message', '予約が完了しました。');
    }

    // 予約キャンセル機能
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('reservations.index')->with('error_message', '不正なアクセスです。');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')->with('flash_message', '予約をキャンセルしました。');
    }
}
