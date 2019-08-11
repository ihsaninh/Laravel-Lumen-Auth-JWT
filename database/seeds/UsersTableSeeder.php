<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ihsan',
            'email' => 'ihsan.inh@gmail.com',
            'password' => Hash::make('123'),
        ]);
    }
}
