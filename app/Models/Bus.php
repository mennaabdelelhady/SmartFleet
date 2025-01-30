<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['trip_id'];
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
