<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Restaurant;

class DuringBusinessHours implements Rule {
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($restaurant_id) {
        $this->restaurant_id = $restaurant_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $opening_time = Restaurant::find($this->restaurant_id)->opening_time;
        $closing_time = Restaurant::find($this->restaurant_id)->closing_time;

        return strtotime($value) >= strtotime($opening_time) && strtotime($value) <= strtotime($closing_time);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return '予約時間が営業時間外です。';
    }
}
