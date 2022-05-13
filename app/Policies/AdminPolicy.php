<?php

namespace App\Policies;

use App\Models\User;
use App\Enum\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isAdmin(User $user)
    {   
        foreach($user->roles as $role){  
            if ($role->role_name == Roles::Admin->toString()){ 
                return True;
            }
        }
        return False;
    }
}
