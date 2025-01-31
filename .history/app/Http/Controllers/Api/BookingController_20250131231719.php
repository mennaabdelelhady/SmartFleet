<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function bookSeat(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'seat_id' => 'required|exists:seats,id',
        'start_station_id' => 'required|exists:cities,id',
        'end_station_id' => 'required|exists:cities,id',
    ]);

    $seat = Seat::find($request->seat_id);
    $bus = $seat->bus;
    $trip = $bus->trip;

    // Check if the seat is available for the given stations
    $isSeatAvailable = !$seat->bookings()
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_station_id', [$request->start_station_id, $request->end_station_id])
                  ->orWhereBetween('end_station_id', [$request->start_station_id, $request->end_station_id]);
        })
        ->exists();

    if (!$isSeatAvailable) {
        return response()->json(['message' => 'Seat is not available for the selected stations'], 400);
    }

    $booking = Booking::create([
        'user_id' => $request->user_id,
        'seat_id' => $request->seat_id,
        'start_station_id' => $request->start_station_id,
        'end_station_id' => $request->end_station_id,
    ]);

    return response()->json(['message' => 'Seat booked successfully', 'booking' => $booking], 201);
}
}
