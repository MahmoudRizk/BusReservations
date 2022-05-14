<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city_name',
        'city_order'
    ];

    protected $hidden = [   
        'created_at',
        'updated_at'
    ];
}
