<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Models\SatuanUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Obuchmann\OdooJsonRpc\Odoo;

class SatuanUnitController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        try {
            $erpUOM = $odoo->model('product.uom')->fields(['name', 'id'])->get();
            $currentUOM = SatuanUnit::pluck('external_satuan_unit_id')->toArray();
            $newUOMList = [];

            foreach ($erpUOM as $uom) {
                if (!in_array($uom->id, $currentUOM) && !collect($newUOMList)->contains('external_satuan_unit_id', $uom->id)) {
                    $newUOMList[] = [
                        'external_satuan_unit_id' => $uom->id,
                        'nama_satuan' => $uom->name,
                        'satuan_unit_produk' => $uom->name,
                        'keterangan' => 'none',
                    ];
                }
            }

            if (!empty($newUOMList)) {
                DB::table('satuan_unit')->insert($newUOMList);
                $allDataQty = count($erpUOM);
                echo "updated: $allDataQty Data ";
                return 'success';
            }

            return 'already imported';
        } catch (\Throwable $th) {
            //throw $th;
            echo 'failed';
        }
    }
}
