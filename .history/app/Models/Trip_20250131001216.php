<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['start_city_id', 'end_city_id', 'bus_id'];
    public function startCity()
    {
        return $this->belongsTo(City::class, 'start_city_id');
    }

    public function endCity()
    {
        return $this->belongsTo(City::class, 'end_city_id');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
