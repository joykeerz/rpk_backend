<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\SatuanUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Obuchmann\OdooJsonRpc\Odoo;

class ProductController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        $erpProducts = $odoo->model('product.product')->fields(['name', 'categ_id', 'uom_id', 'default_code'])->get();
        $currentCategories = Kategori::all();
        $currentSatuanUnits = SatuanUnit::all();
        $currentProducts = Produk::all();

        $newListProduct = [];
        $newListCategory = [];
        $newListSatuanUnit = [];

        foreach ($erpProducts as $key => $value) {
            if (!$currentCategories->contains('external_kategori_id', $erpProducts[$key]->categ_id[0]) && !collect($newListCategory)->contains('external_kategori_id', $erpProducts[$key]->categ_id[0])) {
                array_push($newListCategory, [
                    'external_kategori_id' => $erpProducts[$key]->categ_id[0],
                    'nama_kategori' => $erpProducts[$key]->categ_id[1],
                    'deskripsi_kategori' => $erpProducts[$key]->categ_id[1],
                ]);
            }
            if (!$currentSatuanUnits->contains('external_satuan_unit_id', $erpProducts[$key]->uom_id[0]) && !collect($newListSatuanUnit)->contains('external_satuan_unit_id', $erpProducts[$key]->uom_id[0])) {
                array_push($newListSatuanUnit, [
                    'external_satuan_unit_id' => $erpProducts[$key]->uom_id[0],
                    'nama_satuan' => $erpProducts[$key]->uom_id[1],
                    'satuan_unit_produk' => $erpProducts[$key]->uom_id[1],
                    'keterangan' => 'none',
                ]);
            }
        }
        $insertedCategory = DB::table('kategori')->insert($newListCategory);
        $insertedSatuanUnit = DB::table('satuan_unit')->insert($newListSatuanUnit);
        dd($insertedCategory);
        // foreach ($erpProducts as $key => $value) {
        //     if (!$currentProducts->contains('external_produk_id', $erpProducts[$key]->id) && !$currentProducts->contains('kode_produk', $erpProducts[$key]->default_code) && !collect($newListProduct)->contains('external_produk_id', $erpProducts[$key]->id)) {
        //         array_push($newListProduct, [
        //             'kategori_id' => $erpProducts[$key]->uom_id[0],
        //             'pajak_id' => $erpProducts[$key]->uom_id[1],
        //             'satuan_unit_id' => $erpProducts[$key]->uom_id[1],
        //             'kode_produk' => 'none',
        //             'nama_produk' => 'none',
        //             'desk_produk' => 'none',
        //             'diskon_produk' => 'none',
        //             'external_produk_id' => 'none',
        //         ]);
        //     }
        // }
        $allDataQty = count($erpProducts);
        echo "updated: $allDataQty Data ";
        return 'success';
    }

    public function exportFromErp()
    {
    }

    public function synchronizeErp()
    {
        return 'sync';
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
