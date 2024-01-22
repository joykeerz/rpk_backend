<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\ProductImportJob;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\SatuanUnit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class ProductController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        try {
            dispatch(new ProductImportJob($odoo));
            Log::info('Product Import Job Dispatched Successfully');
            return redirect()->route('product.manage')->with('success', 'Product Import Job Dispatched Successfully');
        } catch (Exception $e) {
            Log::error('Failed to dispatch Product Import Job: ' . $e->getMessage());
            return 'Failed to dispatch Product Import Job';
        }
    }

    public function oldImportFromErp(Odoo $odoo)
    {
        /*
        $erpProducts = $odoo->model('product.product')->fields(['name', 'categ_id', 'uom_id', 'default_code'])->get();
        $currentCategories = Kategori::all();
        $currentSatuanUnits = SatuanUnit::all();
        $currentProducts = Produk::all();

        $newProductList = [];
        $newCategoryList = [];
        $newSatuanUnitList = [];

        foreach ($erpProducts as $key => $value) {
            if (!$currentCategories->contains('external_kategori_id', $erpProducts[$key]->categ_id[0]) && !collect($newCategoryList)->contains('external_kategori_id', $erpProducts[$key]->categ_id[0])) {
                array_push($newCategoryList, [
                    'external_kategori_id' => $erpProducts[$key]->categ_id[0],
                    'nama_kategori' => $erpProducts[$key]->categ_id[1],
                    'deskripsi_kategori' => $erpProducts[$key]->categ_id[1],
                ]);
            }
            if (!$currentSatuanUnits->contains('external_satuan_unit_id', $erpProducts[$key]->uom_id[0]) && !collect($newSatuanUnitList)->contains('external_satuan_unit_id', $erpProducts[$key]->uom_id[0])) {
                array_push($newSatuanUnitList, [
                    'external_satuan_unit_id' => $erpProducts[$key]->uom_id[0],
                    'nama_satuan' => $erpProducts[$key]->uom_id[1],
                    'satuan_unit_produk' => $erpProducts[$key]->uom_id[1],
                    'keterangan' => 'none',
                ]);
            }
        }

        if ($newCategoryList != null && $newSatuanUnitList != null) {
            DB::table('kategori')->insert($newCategoryList);
            DB::table('satuan_unit')->insert($newSatuanUnitList);
        }

        $currentCategories = Kategori::all();
        $currentSatuanUnits = SatuanUnit::all();

        foreach ($erpProducts as $key => $value) {
            $tempCategory = 1;
            $tempSatuanUnit = 1;
            if (!$currentProducts->contains('external_produk_id', $erpProducts[$key]->id) && !$currentProducts->contains('kode_produk', $erpProducts[$key]->default_code) && !collect($newProductList)->contains('external_produk_id', $erpProducts[$key]->id)) {
                if ($currentCategories->contains('external_kategori_id', $erpProducts[$key]->categ_id[0])) {
                    $tempCategory = $currentCategories->where('external_kategori_id', $erpProducts[$key]->categ_id[0])->first()->id;
                }

                if ($currentSatuanUnits->contains('external_satuan_unit_id', $erpProducts[$key]->uom_id[0])) {
                    $tempSatuanUnit = $currentSatuanUnits->where('external_satuan_unit_id', $erpProducts[$key]->uom_id[0])->first()->id;
                }

                array_push($newProductList, [
                    'kategori_id' => $tempCategory,
                    'pajak_id' => 1,
                    'satuan_unit_id' => $tempSatuanUnit,
                    'kode_produk' => $erpProducts[$key]->default_code,
                    'nama_produk' => $erpProducts[$key]->name,
                    'desk_produk' => $erpProducts[$key]->name,
                    'diskon_produk' => 0,
                    'external_produk_id' => $erpProducts[$key]->id,
                ]);
            }
        }

        if ($newProductList != null) {
            DB::table('produk')->insert($newProductList);
        }

        $allDataQty = count($erpProducts);
        echo "updated: $allDataQty Data ";
        return 'success';
        */
    }
    public function examples()
    {
        /* Examples 1

        /// select 1 data
        // $order = $odoo->model('sale.order')
        //     ->where('name', '=', 'SO/10644/10/2023/09001')
        //     ->first();

        /// show field dari tabel
        // $structure = $odoo->listModelFields('product.product');

        /// input data
        // $id = $odoo->create('product.product', [
        //     'name' => 'Beras Pandang Wangi BPW01'
        // ]);


        // $product = $odoo->model('product.product')->where('name', '=', 'Beras Pandang Wangi BPW01')->first();
        // $product = $odoo->model('product.product')->limit(5)->fields(['name','categ_id'])->get();
        // $category = $odoo->model('product.category')->limit(5)->fields(['name','display_name'])->get();
        // $category = $odoo->listModelFields('product.category');
        // dd($category);
        */

        /* Examples 2
        // Find Model by Id
        // $product = $odoo->find('product.template', 1);

        // // Update Model by ID
        // $this->odoo->updateById('product.product', $product->id, [
        //     'name' => $name,
        // ]);

        // // Create returning ID
        // $id = $this->odoo
        //     ->create('res.partner', [
        //         'name' => 'Bobby Brown'
        //     ]);

        // // Search for Models with or
        // $partners = $this->odoo->model('res.partner')
        //     ->where('name', '=', 'Bobby Brown')
        //     ->orWhere('name', '=', 'Gregor Green')
        //     ->limit(5)
        //     ->orderBy('id', 'desc')
        //     ->get();

        // // Update by Query
        // $updateResponse = $this->odoo
        //     ->model('res.partner')
        //     ->where('name', '=', 'Bobby Brown')
        //     ->update([
        //         'name' => 'Dagobert Duck'
        //     ]);
        */
    }
}
