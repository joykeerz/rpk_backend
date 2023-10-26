<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '086969420'
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin2@mail.com',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206969'
        ]);

        DB::table('biodata')->insert([
            'user_id' => 1,
            'nama_rpk' => 'RPK Joy',
            'no_ktp' => '123456789',
        ]);

        DB::table('biodata')->insert([
            'user_id' => 2,
            'nama_rpk' => 'RPK Mahran',
            'no_ktp' => '123456789',
        ]);
    }
}
