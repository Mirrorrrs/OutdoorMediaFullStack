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
    }
}
