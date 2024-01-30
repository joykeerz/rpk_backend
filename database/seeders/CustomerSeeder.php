<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'id' => 5,
            'name' => 'RPK Jhon Doe',
            'email' => 'RpkJhonDoe@mail.com',
            'role_id' => '5',
            'password' => bcrypt('admin123'),
            'no_hp' => '0217563028',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('alamat')->insert([
            'jalan' => 'Jl Gatot Subroto',
            'jalan_ext' => 'Gg Batuan tiga',
            'blok' => 'Blok SS No.5',
            'rt' => '1',
            'rw' => '1',
            'provinsi' => 'DKI JAKARTA',
            'kota_kabupaten' => 'KOTA JAKARTA SELATAN',
            'kecamatan' => 'KEBAYORAN LAMA',
            'kelurahan' => 'KEBAYORAN LAMA SELATAN',
            'negara' => 'Indonesia',
            'kode_pos' => '15318',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('biodata')->insert([
            'id' => 2,
            'user_id' => 5,
            'alamat_id' => 3,
            'kode_customer' => 'C0001',
            'nama_rpk' => 'RPK Jhon Doe',
            'no_ktp' => '1234567890',
            'kode_company' => 'J0001',
            'ktp_img' => 'images/ktp/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
        ]);
    }
}
