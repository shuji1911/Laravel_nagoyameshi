<?php

namespace App\Http\Requests;

use App\Rules\during_business_hours;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AfterCurrentDate;
use App\Rules\DuringBusinessHours;

class ReservationRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        $restaurant_id = $this->input('restaurant_id');

        return [
            'reservation_date' => ['required', 'date_format:Y-m-d'],
            'reservation_time' => ['required', 'date_format:H:i', new DuringBusinessHours($restaurant_id)],
            'reservation_datetime' => [new AfterCurrentDate]
        ];
    }

    protected function prepareForValidation() {
        $reservation_datetime = $this->reservation_date . ' ' . $this->reservation_time;
        $this->merge([
            'reservation_datetime' => $reservation_datetime
        ]);
    }
}
