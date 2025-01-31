<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookSeatRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'seat_id' => 'required|exists:seats,id',
            'start_station_id' => 'required|exists:cities,id',
            'end_station_id' => 'required|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The specified user does not exist.',
            'seat_id.required' => 'The seat ID is required.',
            'seat_id.exists' => 'The specified seat does not exist.',
            'start_station_id.required' => 'The start station ID is required.',
            'start_station_id.exists' => 'The specified start station does not exist.',
            'end_station_id.required' => 'The end station ID is required.',
            'end_station_id.exists' => 'The specified end station does not exist.',
        ];
    }
}