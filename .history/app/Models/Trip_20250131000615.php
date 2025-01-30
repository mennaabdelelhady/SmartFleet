<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
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
