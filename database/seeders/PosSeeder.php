<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Customer RPK Test',
            'email' => 'customerTest777@mail.com',
            'role_id' => '5',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206769',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_profiles')->insert([
            'user_id' => 4,
            'pos_name' => 'POS CUSTOMER JOY',
            'pin' => '010620',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'profile_id' => 1,
            'category_name' => 'Beras',
            'category_desc' => 'beras asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'profile_id' => 1,
            'category_name' => 'Kecap',
            'category_desc' => 'Kecap asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 1,
            'category_id' => 1,
            'product_code' => 'BPW01',
            'product_name' => 'Beras Pandan Wangi 1',
            'product_image' => 'images/product/BNQYGmaZFWtpXKXCl9v6zc1eBt56fuQdPmrCrr8Z.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 1,
            'quantity' => 30,
            'price' => 19500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 1,
            'category_id' => 2,
            'product_code' => 'KB01',
            'product_name' => 'Kecap Bangau 1',
            'product_image' => 'images/product/BNQYGmaZFWtpXKXCl9v6zc1eBt56fuQdPmrCrr8Z.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 2,
            'quantity' => 40,
            'price' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
