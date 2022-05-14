<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'trip_name',
        'from_city_id',
        'to_city_id'
    ];

    public function from_city()
    {
        return $this->belongsTo(City::class);
    }

    public function to_city()
    {
        return $this->belongsTo(City::class);
    }
}
