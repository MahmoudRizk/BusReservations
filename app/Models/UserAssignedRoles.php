<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignedRoles extends Model
{

    protected $fillable = [
        'role_name',
        'user_id'
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
