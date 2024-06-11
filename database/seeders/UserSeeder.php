<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "first_name" => "Admin",
            "last_name" => "",
            "full_name" => "",
            "date_of_birth" => '2000-11-07',
            "is_admin" => true,
            "email" => "admin@gmail.com",
            "password"=> "123456"

        ]);
    }
}
