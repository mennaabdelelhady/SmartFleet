<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Booking;

class BookingController extends Controller
{
    public function bookSeat(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seat_id' => 'required|exists:seats,id',
            'start_station_id' => 'required|exists:cities,id',
            'end_station_id' => 'required|exists:cities,id',
        ], [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The specified user does not exist.',
            'seat_id.required' => 'The seat ID is required.',
            'seat_id.exists' => 'The specified seat does not exist.',
            'start_station_id.required' => 'The start station ID is required.',
            'start_station_id.exists' => 'The specified start station does not exist.',
            'end_station_id.required' => 'The end station ID is required.',
            'end_station_id.exists' => 'The specified end station does not exist.',
        ]);

        // Find the seat
        $seat = Seat::find($request->seat_id);
        $bus = $seat->bus;
        $trip = $bus->trip;

        // Check if the seat is already booked for the given stations
        $isSeatAvailable = !$seat->bookings()
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_station_id', [$request->start_station_id, $request->end_station_id])
                      ->orWhereBetween('end_station_id', [$request->start_station_id, $request->end_station_id]);
            })
            ->exists();

        if (!$isSeatAvailable) {
            return response()->json(['message' => 'Seat is not available for the selected stations'], 400);
        }

        // Create the booking
        try {
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'seat_id' => $request->seat_id,
                'start_station_id' => $request->start_station_id,
                'end_station_id' => $request->end_station_id,
            ]);

            return response()->json(['message' => 'Seat booked successfully', 'booking' => $booking], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while booking the seat', 'error' => $e->getMessage()], 500);
        }
    }
}