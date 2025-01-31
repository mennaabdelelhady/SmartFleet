<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function getAvailableSeats(Request $request)
    {
        $request->validate([
            'start_station_id' => 'required|exists:cities,id',
            'end_station_id' => 'required|exists:cities,id',
        ]);

        $startStationId = $request->start_station_id;
        $endStationId = $request->end_station_id;

        $availableSeats = Seat::whereDoesntHave('bookings', function ($query) use ($startStationId, $endStationId) {
            $query->whereBetween('start_station_id', [$startStationId, $endStationId])
                  ->orWhereBetween('end_station_id', [$startStationId, $endStationId]);
        })->get();

        return response()->json(['available_seats' => $availableSeats], 200);
    }
}
