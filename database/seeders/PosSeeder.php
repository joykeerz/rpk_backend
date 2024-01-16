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
            'id' => 4,
            'name' => 'Customer RPK Test',
            'email' => 'customerTest777@mail.com',
            'role_id' => '5',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206769',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_profiles')->insert([
            'id' => 1,
            'user_id' => 4,
            'pos_name' => 'POS CUSTOMER JOY',
            'pin' => '010620',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'id' => 1,
            'profile_id' => 1,
            'category_name' => 'Beras',
            'category_desc' => 'beras asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'id' => 2,
            'profile_id' => 1,
            'category_name' => 'Kecap',
            'category_desc' => 'Kecap asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'id' => 1,
            'profile_id' => 1,
            'category_id' => 1,
            'product_code' => 'BPW01',
            'product_name' => 'Beras Pandan Wangi 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  beras ini dijual per 5kg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'id' => 1,
            'product_id' => 1,
            'quantity' => 30,
            'price' => 19500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'id' => 2,
            'profile_id' => 1,
            'category_id' => 2,
            'product_code' => 'KB01',
            'product_name' => 'Kecap Bangau 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  jangan dijual ke anak balita',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'id' => 2,
            'product_id' => 2,
            'quantity' => 40,
            'price' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('pos_products')->insert([
            'id' => 3,
            'profile_id' => 1,
            'category_id' => 2,
            'product_code' => 'KBU01',
            'product_name' => 'Kecap Kerbau 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  kerbau tidak memproduksi kecap',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'id' => 3,
            'product_id' => 3,
            'quantity' => 40,
            'price' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'id' => 4,
            'profile_id' => 1,
            'category_id' => 1,
            'product_code' => 'BM01',
            'product_name' => 'Beras Merah 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note: beras merah tidak merah aslinya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'id' => 4,
            'product_id' => 4,
            'quantity' => 40,
            'price' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'id' => 5,
            'profile_id' => 1,
            'category_id' => 1,
            'product_code' => 'BU01',
            'product_name' => 'Beras Ungu 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'tidak ada catatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'id' => 5,
            'product_id' => 5,
            'quantity' => 40,
            'price' => 19000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
