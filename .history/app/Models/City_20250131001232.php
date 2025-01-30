<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];
    public function trips()
    {
        return $this->hasMany(Trip::class, 'start_city_id');
    }
}
