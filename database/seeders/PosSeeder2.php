<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PosSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pos_discounts')->insert([
            'profile_id' => 2,
            'discount_name' => 'No Discount',
            'discount_type' => 'none',
            'discount_value' => 0,
        ]);

        DB::table('pos_promos')->insert([
            'profile_id' => 2,
            'promo_name' => 'No Promo',
            'promo_type' => 'none',
            'promo_category' => 'none',
            'promo_value' => 0,
            'promo_start' => now(),
            'promo_end' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'profile_id' => 2,
            'category_name' => 'Beras',
            'category_desc' => 'beras asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_categories')->insert([
            'profile_id' => 2,
            'category_name' => 'Kecap',
            'category_desc' => 'Kecap asli dengan kualitas tinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 2,
            'category_id' => 1,
            'product_code' => 'BPW01',
            'product_name' => 'Beras Pandan Wangi 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  beras ini dijual per 5kg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 1,
            'discount_id' => 1, // 'Tidak ada
            'quantity' => 30,
            'price' => 19500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 2,
            'category_id' => 2,
            'product_code' => 'KB01',
            'product_name' => 'Kecap Bangau 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  jangan dijual ke anak balita',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 2,
            'discount_id' => 1, // 'Tidak ada
            'quantity' => 40,
            'price' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('pos_products')->insert([
            'profile_id' => 2,
            'category_id' => 2,
            'product_code' => 'KBU01',
            'product_name' => 'Kecap Kerbau 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note:  kerbau tidak memproduksi kecap',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 3,
            'discount_id' => 1, // 'Tidak ada
            'quantity' => 40,
            'price' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 2,
            'category_id' => 1,
            'product_code' => 'BM01',
            'product_name' => 'Beras Merah 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'note: beras merah tidak merah aslinya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 4,
            'discount_id' => 1, // 'Tidak ada
            'quantity' => 40,
            'price' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_products')->insert([
            'profile_id' => 2,
            'category_id' => 1,
            'product_code' => 'BU01',
            'product_name' => 'Beras Ungu 1',
            'product_image' => 'images/product/CErQ8mg3hkdl0wjutiCGnalzkKWHj6aifISPbJ6K.jpg',
            'product_desc' => 'tidak ada catatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pos_inventories')->insert([
            'product_id' => 5,
            'discount_id' => 1, // 'Tidak ada
            'quantity' => 40,
            'price' => 19000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
