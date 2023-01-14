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

        // create karyawan
        Karyawan::create([
            'nik' => '20231',
            'nama' => 'haykal',
            'email' =>  'haykal@gmail.com',
            'departemen' =>  'A',
            'tgl_lahir' =>  '19-09-1981',
            'no_hp' =>  '089121330'
        ]);
        Karyawan::create([
            'nik' => '20232',
            'nama' => 'akmal',
            'email' =>  'akmal@gmail.com',
            'departemen' =>  'B',
            'tgl_lahir' =>  '19-09-1982',
            'no_hp' =>  '089121331'
        ]);
        Karyawan::create([
            'nik' => '20233',
            'nama' => 'rohim',
            'email' =>  'rohim@gmail.com',
            'departemen' =>  'C',
            'tgl_lahir' =>  '19-09-1983',
            'no_hp' =>  '089121332'
        ]);
        Karyawan::create([
            'nik' => '20234',
            'nama' => 'amet',
            'email' =>  'amet@gmail.com',
            'departemen' =>  'A',
            'tgl_lahir' =>  '19-09-1984',
            'no_hp' =>  '089121333'
        ]);
        Karyawan::create([
            'nik' => '20235',
            'nama' => 'mamat',
            'email' =>  'mamat@gmail.com',
            'departemen' =>  'B',
            'tgl_lahir' =>  '19-09-1986',
            'no_hp' =>  '0891213315'
        ]);
        Karyawan::create([
            'nik' => '20236',
            'nama' => 'zidan',
            'email' =>  'zidan@gmail.com',
            'departemen' =>  'C',
            'tgl_lahir' =>  '19-09-1981',
            'no_hp' =>  '089121336'
        ]);
    }
}
