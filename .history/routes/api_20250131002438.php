<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\SeatController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});