<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Karyawan;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $karyawan = Faker::create('id_ID');
        for ($i=1; $i <= 200; $i++) { 
        	\DB::table('karyawan')->insert([
        		'nik' => $karyawan->unique()->numberBetween(20301, 30000),
        		'nama' => $karyawan->name,
        		'email' => $karyawan->email,
        		'departemen' => $karyawan->randomElement(['A', 'B','C']),
        		'tgl_lahir' => $karyawan->date('d-m-Y'),
        		'no_hp' => $karyawan->unique()->numberBetween(62812345500, 62812346000)
        	]);
        }
    }
}
