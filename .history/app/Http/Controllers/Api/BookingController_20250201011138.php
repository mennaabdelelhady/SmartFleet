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
       // Validation is already handled by BookSeatRequest
}