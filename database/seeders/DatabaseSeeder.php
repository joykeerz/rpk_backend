<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\table;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('roles')->insert([
            'nama_role' => 'Super Admin',
            'desk_role' => 'Manager of system or developer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Manager Sales Pusat',
            'desk_role' => 'Mengatur master data produk, kategori dan gudang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Manager Sales Kanwil',
            'desk_role' => 'Mengatur validasi pendaftaran',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Kepala Gudang',
            'desk_role' => 'Mengatur Pengiriman Barang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Pengguna RPK',
            'desk_role' => 'Akun RPK',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'role_id' => '1',
            'password' => Hash::make('admin123'),
            'no_hp' => '086969420',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin2@mail.com',
            'role_id' => '2',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206969',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('alamat')->insert([
            'jalan' => 'none',
            'jalan_ext' => 'none',
            'blok' => 'none',
            'rt' => 'none',
            'rw' => 'none',
            'provinsi' => 'none',
            'kota_kabupaten' => 'none',
            'kecamatan' => 'none',
            'kelurahan' => 'none',
            'negara' => 'none',
            'kode_pos' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('alamat')->insert([
            'jalan' => 'Jl. Nusa Bangsa',
            'jalan_ext' => 'Gg. Riya Raya',
            'blok' => 'Blok Jk No. 11',
            'rt' => '05',
            'rw' => '10',
            'provinsi' => 'Banten',
            'kota_kabupaten' => 'Tangerang',
            'kecamatan' => 'Serpong',
            'kelurahan' => 'Rawa Buaya',
            'negara' => 'Indonesia',
            'kode_pos' => '15318',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('alamat')->insert([
            'jalan' => 'Jl. Nusa Raya',
            'jalan_ext' => 'Gg. Bangsa Raya',
            'blok' => 'Blok PU No. 11',
            'rt' => '11',
            'rw' => '05',
            'provinsi' => 'Banten',
            'kota_kabupaten' => 'Tangerang',
            'kecamatan' => 'Serpong',
            'kelurahan' => 'Rawa Ikan',
            'negara' => 'Indonesia',
            'kode_pos' => '15310',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('biodata')->insert([
            'user_id' => 1,
            'alamat_id' => 1,
            'nama_rpk' => 'RPK Joy',
            'no_ktp' => '123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('biodata')->insert([
            'user_id' => 2,
            'alamat_id' => 2,
            'nama_rpk' => 'RPK Mahran',
            'no_ktp' => '123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
