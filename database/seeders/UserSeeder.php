<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Karyawan};
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Haykalm',
            'email' => 'haykalm@gmail.com',
            'password' =>  Hash::make('password')
        ]);
        User::create([
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'password' =>  Hash::make('password')
        ]);
        User::create([
            'name' => 'parjo',
            'email' => 'parjo@gmail.com',
            'password' =>  Hash::make('password')
        ]);
        User::create([
            'name' => 'aji',
            'email' => 'aji@gmail.com',
            'password' =>  Hash::make('password')
        ]);
        User::create([
            'name' => 'papah',
            'email' => 'papah@gmail.com',
            'password' =>  Hash::make('password')
        ]);
    }
}
