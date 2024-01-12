<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\UserImportJob;
use App\Models\Kategori;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class CategoryController extends Controller
{
    //
    public function importFromErp(Odoo $odoo)
    {
        $erpCategories = $odoo->model('product.category')->fields(['name', 'id'])->get();
        $currentCategories = Kategori::all();
        $newCategoryList = [];

        foreach ($erpCategories as $key => $value) {
            if (!$currentCategories->contains('external_kategori_id', $erpCategories[$key]->id) && !collect($newCategoryList)->contains('external_kategori_id', $erpCategories[$key]->id)) {
                array_push($newCategoryList, [
                    'external_kategori_id' => $erpCategories[$key]->id,
                    'nama_kategori' => $erpCategories[$key]->name,
                    'deskripsi_kategori' => $erpCategories[$key]->name,
                ]);
            }
        }

        if ($newCategoryList != null) {
            DB::table('kategori')->insert($newCategoryList);
            $allDataQty = count($erpCategories);
            echo "updated: $allDataQty Data ";
            return 'success';
        }

        return 'failed';
    }
}
