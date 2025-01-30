<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function trips()
    {
        return $this->hasMany(Trip::class, 'start_city_id');
    }
}
