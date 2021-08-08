<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'first_name' => 'seif',
            'last_name' => 'obeid',
            'email' => Str::random(10).'@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('seifobeid'),
        ]);
    }
}
