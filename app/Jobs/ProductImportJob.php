<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function importCategory(Odoo $odoo)
    {
        /*
        Log::info('Importing Category');
        $erpCategory = $odoo->model('product.category')->fields(['id', 'name'])->get();
        $newCategoryList = [];
        Log::info('Looping through category data...');
        foreach ($erpCategory as $cat) {
            $newCategoryList[] = [
                'id' => $cat->id,
                'nama_kategori' => $cat->name,
                'deskripsi_kategori' => $cat->name,
            ];
        }
        if (!empty($newCategoryList)) {
            Log::info('Inserting category data to database...');
            DB::table('kategori')->insert($newCategoryList);
        }
        Log::info('Category import job finished');
        */
        Log::info('Importing Category');
        $erpCategory = $odoo->model('product.category')->fields(['id', 'name'])->get();
        Log::info('Looping through category data...');
        foreach ($erpCategory as $cat) {
            DB::table('kategori')->updateOrInsert(['id' => $cat->id], [
                'id' => $cat->id,
                'nama_kategori' => $cat->name,
                'deskripsi_kategori' => $cat->name,
            ]);
        }
        Log::info('Category import job finished');
    }

    public function importSatuanUnit(Odoo $odoo)
    {
        /*
        Log::info('Importing Satuan Unit');
        $erpSatuanUnit = $odoo->model('product.uom')->fields(['id', 'name'])->get();
        $newSatuanUnitList = [];
        Log::info('Looping through satuan unit data...');
        foreach ($erpSatuanUnit as $satuan) {
            $newSatuanUnitList[] = [
                'id' => $satuan->id,
                'nama_satuan' => $satuan->name,
                'satuan_unit_produk' => $satuan->name,
                'keterangan' => 'tidak ada',
            ];
        }
        if (!empty($newSatuanUnitList)) {
            Log::info('Inserting satuan unit data to database...');
            DB::table('satuan_unit')->insert($newSatuanUnitList);
        }
        */

        Log::info('Importing Satuan Unit');
        $erpSatuanUnit = $odoo->model('product.uom')->fields(['id', 'name'])->get();
        Log::info('Looping through satuan unit data...');
        foreach ($erpSatuanUnit as $satuan) {
            DB::table('satuan_unit')->updateOrInsert(['id' => $satuan->id], [
                'id' => $satuan->id,
                'nama_satuan' => $satuan->name,
                'satuan_unit_produk' => $satuan->name,
                'keterangan' => 'tidak ada',
            ]);
        }
        Log::info('Satuan Unit import job finished');
    }

    public function importProduct(Odoo $odoo)
    {
        /*
        Log::info('Importing Product');
        $erProduct = $odoo->model('product.product')->fields(['name', 'categ_id', 'uom_id', 'default_code'])->get();
        $newProductList = [];
        Log::info('Looping through product data...');
        foreach ($erProduct as $product) {
            $newProductList[] = [
                'id' => $product->id,
                'kategori_id' => $product->categ_id[0],
                'pajak_id' => 1,
                'satuan_unit_id' => $product->uom_id[0],
                'kode_produk' => $product->default_code,
                'nama_produk' => $product->name,
                'desk_produk' => $product->name,
                'diskon_produk' => 0,
            ];
        }
        if (!empty($newProductList)) {
            Log::info('Inserting product data to database...');
            DB::table('produk')->insert($newProductList);
        }
        */

        Log::info('Importing Product');
        $erProduct = $odoo->model('product.product')->fields(['name', 'categ_id', 'uom_id', 'default_code'])->get();
        Log::info('Looping through product data...');
        foreach ($erProduct as $product) {
            DB::table('produk')->updateOrInsert(['id' => $product->id], [
                'id' => $product->id,
                'kategori_id' => $product->categ_id[0],
                'pajak_id' => 1,
                'satuan_unit_id' => $product->uom_id[0],
                'kode_produk' => $product->default_code,
                'nama_produk' => $product->name,
                'desk_produk' => $product->name,
                'diskon_produk' => 0,
            ]);
        }
        Log::info('Product import job finished');
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        Log::info('Product import job Running');
        $this->importCategory($odoo);
        $this->importSatuanUnit($odoo);
        $this->importProduct($odoo);
        Log::info('Product import job finished');
    }
}
