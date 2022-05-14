<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Administrator
        DB::table('users') -> insert([ 
            'id' => 1, 
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678')
        ]);
        
        // Customer
        DB::table('users') -> insert([  
            'id' => 2,
            'name' => 'MRizk',
            'email' => 'mrizk@test.com',
            'password' => Hash::make('12345678')
        ]);

        // Apply user roles
        // TODO: find elegant way for assigning user_id instead of hard coding it. Maybe use data factories.
        DB::table('user_assigned_roles') -> insert([  
            'user_id' => 1,
            'role_name' => 'Admin'
        ]);

        DB::table('user_assigned_roles') -> insert([  
            'user_id' => 2,
            'role_name' => 'Customer'
        ]);
        
        // Add cities
        DB::table('cities') -> insert([
            'id' => 1,  
            'city_name' => 'Cairo',
            'city_order' => '10'
        ]);
        
        DB::table('cities') -> insert([
            'id' => 2,  
            'city_name' => 'AlFayyum',
            'city_order' => '20'
        ]);
        
        DB::table('cities') -> insert([ 
            'id' => 3, 
            'city_name' => 'AlMinya',
            'city_order' => '30'
        ]);
        
        DB::table('cities') -> insert([
            'id' => 4,  
            'city_name' => 'Asyut',
            'city_order' => '40'
        ]); 


        // Add first trip
        DB::table('trips') -> insert([  
            'trip_name' => 'First Trip',
            'from_city_id' => 1,
            'to_city_id' => 4,
            'max_seats_number' => 12
        ]);

    }
}
