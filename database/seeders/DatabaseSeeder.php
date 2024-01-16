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
            'id' => 1,
            'nama_role' => 'none',
            'desk_role' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'nama_role' => 'Super Admin',
            'desk_role' => 'Manager of system or developer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'nama_role' => 'Penjual Pusat',
            'desk_role' => 'penjual pusat bulog',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'id' => 4,
            'nama_role' => 'Manager Sales',
            'desk_role' => 'manager sales cabang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'id' => 5,
            'nama_role' => 'customer',
            'desk_role' => 'pengguna rpk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin User Seed
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'role_id' => '2',
            'password' => Hash::make('admin123'),
            'no_hp' => '08123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Penjual Pusat',
            'email' => 'penjual@mail.com',
            'role_id' => '3',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206969',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Manajer Sales Jakarta Selatan',
            'email' => 'manajer@mail.com',
            'role_id' => '4',
            'password' => Hash::make('admin123'),
            'no_hp' => '084206960',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Alamat Seed
        DB::table('alamat')->insert([
            'id' => 1,
            'jalan' => 'Jl Sukrawetan',
            'jalan_ext' => 'Gg Batuan Satu',
            'blok' => 'Blok JA No.3',
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

        // Kategori Seed
        DB::table('kategori')->insert([
            'id' => 1,
            'nama_kategori' => 'none',
            'deskripsi_kategori' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'id' => 2,
            'nama_kategori' => 'Beras Khusus',
            'deskripsi_kategori' => 'Beras asli',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'id' => 3,
            'nama_kategori' => 'Minyak Goreng',
            'deskripsi_kategori' => 'Minyak sawit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kategori')->insert([
            'id' => 4,
            'nama_kategori' => 'Daging',
            'deskripsi_kategori' => 'Daging asli',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //pajak
        DB::table('pajak')->insert([
            'id' => 1,
            'nama_pajak' => 'Dibebaskan',
            'jenis_pajak' => 'Dibebaskan',
            'persentase_pajak' => 11,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //satuan unit
        DB::table('satuan_unit')->insert([
            'id' => 1,
            'nama_satuan' => 'none',
            'satuan_unit_produk' => 'none',
            'keterangan' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('satuan_unit')->insert([
            'id' => 2,
            'nama_satuan' => 'Kilogram',
            'satuan_unit_produk' => 'Kg',
            'keterangan' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //produk
        DB::table('produk')->insert([
            'id' => 1,
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
            'id' => 2,
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
            'id' => 3,
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
            'id' => 1,
            'produk_id' => 1,
            'gudang_id' => 1,
            'jumlah_stok' => 420,
            'harga_stok' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('stok')->insert([
            'id' => 2,
            'produk_id' => 2,
            'gudang_id' => 1,
            'jumlah_stok' => 69,
            'harga_stok' => 30000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('stok')->insert([
            'id' => 3,
            'produk_id' => 3,
            'gudang_id' => 1,
            'jumlah_stok' => 86,
            'harga_stok' => 120000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Companies Seed
        DB::table('companies')->insert([
            'id' => 1,
            'alamat_id' => 1,
            'user_id' => 3,
            'kode_company' => 'J0001',
            'nama_company' => 'Kanwil Jakarta Selatan',
            'partner_company' => 'none',
            'tagline_company' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Gudang Seed
        DB::table('gudang')->insert([
            'id' => 1,
            'alamat_id' => 1,
            'company_id' => 1,
            'user_id' => 3,
            'nama_gudang' => 'Gudang Jakarta Selatan',
            'no_telp' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Branch Seed
        DB::table('branches')->insert([
            'id' => 1,
            'company_id' => 1,
            'nama_branch' => 'Kancab Jakarta Selatan',
            'no_telp_branch' => 'none',
            'alamat_branch' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //kurir seeder
        DB::table('kurir')->insert([
            'id' => 1,
            'nama_kurir' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kurir')->insert([
            'id' => 2,
            'nama_kurir' => 'JNE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $this->call([
            PosSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
