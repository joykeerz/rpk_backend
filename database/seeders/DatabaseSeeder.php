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
        // Roles Seed
        DB::table('roles')->insert([
            'nama_role' => 'none',
            'desk_role' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Super Admin',
            'desk_role' => 'Manager of system or developer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Penjual Pusat',
            'desk_role' => 'penjual pusat bulog',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'Manager Sales',
            'desk_role' => 'manager sales cabang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nama_role' => 'customer',
            'desk_role' => 'pengguna rpk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin User Seed
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'role_id' => '2',
            'password' => Hash::make('admin123'),
            'no_hp' => '08123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Penjual Pusat',
            'email' => 'penjual@mail.com',
            'role_id' => '3',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206969',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Manajer Sales',
            'email' => 'manajer@mail.com',
            'role_id' => '4',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206960',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Alamat Seed
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

        // Kategori Seed
        DB::table('kategori')->insert([
            'nama_kategori' => 'none',
            'deskripsi_kategori' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'nama_kategori' => 'Beras Khusus',
            'deskripsi_kategori' => 'Beras asli',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'nama_kategori' => 'Minyak Goreng',
            'deskripsi_kategori' => 'Minyak sawit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'nama_kategori' => 'Daging',
            'deskripsi_kategori' => 'Daging asli',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //pajak
        DB::table('pajak')->insert([
            'nama_pajak' => 'Non Pajak',
            'jenis_pajak' => 'Non',
            'persentase_pajak' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //satuan unit
        DB::table('satuan_unit')->insert([
            'nama_satuan' => 'none',
            'satuan_unit_produk' => 'none',
            'keterangan' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('satuan_unit')->insert([
            'nama_satuan' => 'Kilogram',
            'satuan_unit_produk' => 'Kg',
            'keterangan' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //produk
        DB::table('produk')->insert([
            'kategori_id' => 2,
            'pajak_id' => 1,
            'satuan_unit_id' => 2,
            'kode_produk' => 'B0001',
            'nama_produk' => 'Beras Al Hambra Biryani Kemasan',
            'desk_produk' => 'none',
            'diskon_produk' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('produk')->insert([
            'kategori_id' => 3,
            'pajak_id' => 1,
            'satuan_unit_id' => 2,
            'kode_produk' => 'M0001',
            'nama_produk' => 'Minyak Goreng Bimoli',
            'desk_produk' => 'none',
            'diskon_produk' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('produk')->insert([
            'kategori_id' => 4,
            'pajak_id' => 1,
            'satuan_unit_id' => 2,
            'kode_produk' => 'D0001',
            'nama_produk' => 'Daging Sapi Wagyu',
            'desk_produk' => 'none',
            'diskon_produk' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ///stok seeder
        DB::table('stok')->insert([
            'produk_id' => 1,
            'gudang_id' => 1,
            'jumlah_stok' => 420,
            'harga_stok' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('stok')->insert([
            'produk_id' => 2,
            'gudang_id' => 1,
            'jumlah_stok' => 69,
            'harga_stok' => 30000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('stok')->insert([
            'produk_id' => 3,
            'gudang_id' => 1,
            'jumlah_stok' => 86,
            'harga_stok' => 120000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Companies Seed
        DB::table('companies')->insert([
            'alamat_id' => 1,
            'user_id' => 1,
            'kode_company' => 'none',
            'nama_company' => 'none',
            'partner_company' => 'none',
            'tagline_company' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Gudang Seed
        DB::table('gudang')->insert([
            'alamat_id' => 1,
            'company_id' => 1,
            'user_id' => 1,
            'nama_gudang' => 'none',
            'no_telp' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Branch Seed
        DB::table('branches')->insert([
            'company_id' => 1,
            'nama_branch' => 'none',
            'no_telp_branch' => 'none',
            'alamat_branch' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //kurir seeder
        DB::table('kurir')->insert([
            'nama_kurir' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kurir')->insert([
            'nama_kurir' => 'JNE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
