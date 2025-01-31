<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function getAvailableSeats(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_station_id' => 'required|exists:cities,id',
            'end_station_id' => 'required|exists:cities,id',
        ], [
            'start_station_id.required' => 'The start station ID is required.',
            'start_station_id.exists' => 'The specified start station does not exist.',
            'end_station_id.required' => 'The end station ID is required.',
            'end_station_id.exists' => 'The specified end station does not exist.',
        ]);

        $startStationId = $request->start_station_id;
        $endStationId = $request->end_station_id;

        // Fetch available seats
        try {
            $availableSeats = Seat::whereDoesntHave('bookings', function ($query) use ($startStationId, $endStationId) {
                $query->whereBetween('start_station_id', [$startStationId, $endStationId])
                      ->orWhereBetween('end_station_id', [$startStationId, $endStationId]);
            })->select('id', 'bus_id', 'seat_number')->get();

            return response()->json(['available_seats' => $availableSeats], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching available seats', 'error' => $e->getMessage()], 500);
        }
    }
}