<?php

namespace App\Enum;

enum Roles: string
{   
    case Customer = 'Customer';
    case Admin = 'Admin';

    public function toString(): string
    {   
        return match($this)
        {   
            Roles::Customer => 'Customer',
            Roles::Admin => 'Admin'
        };
    }
}