<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Obuchmann\OdooJsonRpc\Odoo;

class GudangController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        $warehouse = $odoo->model('stock.warehouse')->fields(['id', 'name', 'code', 'mobile', 'company_id', 'kepala_gudang'])->limit(50)->offset(1)->get();
        $newWarehouse = [];
        // dd($warehouse);

        foreach ($warehouse as $data) {
            $externalId = $data->id;
            $existingGudang = Gudang::where('external_gudang_id', $externalId)->select('id')->first();
            $existingUser = DB::table('users')->where('external_user_id', $data->kepala_gudang[0])->select('id')->first();
            $existingCompany = DB::table('companies')->where('external_company_id', $data->company_id[0])->select('id')->first();

            if (!$data->mobile) {
                $data->mobile = '-';
            }

            if (!$existingGudang) {
                $alamatID = DB::table('alamat')->insertGetId([
                    'jalan' => 'Jl. Gatot Subroto',
                    'jalan_ext' => 'No.Kav. 49',
                    'blok' => '(blank)',
                    'rt' => '5',
                    'rw' => '4',
                    'provinsi' => 'DKI JAKARTA',
                    'kota_kabupaten' => 'KOTA JAKARTA SELATAN',
                    'kecamatan' => 'SETIA BUDI',
                    'kelurahan' => 'KARET KUNINGAN',
                    'negara' => 'Indonesia',
                    'kode_pos' => '12950',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $newWarehouse[] = [
                    'company_id' => $existingCompany->id,
                    'external_gudang_id' => $data->id,
                    'nama_gudang' => $data->name,
                    'no_telp' => $data->mobile,
                    'user_id' => $existingUser->id,
                    'alamat_id' => $alamatID,
                ];
            }
        }

        if (!empty($newWarehouse)) {
            Gudang::insert($newWarehouse);
            $allDataQty = count($warehouse);
            echo "updated: $allDataQty Data ";
            return 'success';
        }
        return 'already imported';
    }
}
