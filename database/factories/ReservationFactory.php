<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        $restaurants = Restaurant::all();
        $number_restaurants = Restaurant::count() - 1;
        $random_number_restaurant = mt_rand(0, $number_restaurants);
        $restaurant_id = $restaurants[$random_number_restaurant]->id;

        $users = User::all();
        $number_users = User::count() - 1;
        $random_number_user = mt_rand(0, $number_users);
        $user_id = $users[$random_number_user]->id;

        $opening_time = Restaurant::find($restaurant_id)->opening_time;
        $closing_time = Restaurant::find($restaurant_id)->closing_time;
        $random_datetime = $this->faker->dateTimeBetween('-2 week', '+2 week');
        $random_date = $random_datetime->format("Y-m-d");
        $start_datetime = $random_date . ' ' . $opening_time;
        $end_datetime = $random_date . ' ' . $closing_time;

        return [
            'reservation_datetime' => $this->faker->dateTimeBetween($start_datetime, $end_datetime),
            'number_of_people' => mt_rand(1, 10),
            'restaurant_id' => $restaurant_id,
            'user_id' => $user_id,
        ];
    }
}
