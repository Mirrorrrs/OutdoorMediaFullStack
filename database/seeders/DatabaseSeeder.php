<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "login"=>"admin",
            "password"=>Hash::make("UnTh2#Q")
        ]);

        Reservation::create([
           "billboard_id"=>13,
            "from"=>Carbon::now()->addDay(1),
            "to"=>Carbon::now()->addDay(2),
            "booked"=>false,
        ]);

        Reservation::create([
            "billboard_id"=>13,
            "from"=>Carbon::now()->addYear(1)->addDay(1),
            "to"=>Carbon::now()->addYear(1)->addDay(2),
            "booked"=>false,
        ]);

        Reservation::create([
            "billboard_id"=>13,
            "from"=>Carbon::now()->addYear(1)->addDay(1)->addMonth(1),
            "to"=>Carbon::now()->addYear(1)->addDay(2)->addMonth(1),
            "booked"=>false,
        ]);

        Reservation::create([
            "billboard_id"=>13,
            "from"=>Carbon::now()->addYear(2)->addDay(1)->addMonth(1),
            "to"=>Carbon::now()->addYear(2)->addDay(2)->addMonth(1),
            "booked"=>false,
        ]);
    }
}
