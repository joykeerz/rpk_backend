<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Obuchmann\OdooJsonRpc\Odoo;

class CompanyController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        // try {
            $erpCompany = $odoo->model('res.company')->fields(['id', 'code', 'name', 'partner_id', 'user_id', 'street'])->offset(1)->get();
            // dd($erpCompany[1]->partner_id[0]);
            $currentCompany = Company::select('external_company_id')->get();
            $newCompany = [];

            // Loop through chunks of 1000 users
            foreach (array_chunk($erpCompany, 1000) as $chunk) {
                foreach ($chunk as $company) {
                    if (!$currentCompany->contains('external_company_id', $company->id) && !collect($newCompany)->contains('external_company_id', $company->id)) {
                        if(!$company->partner_id){
                            $company->partner_id[0] = 1;
                        }

                        if (!$company->user_id) {
                            $company->user_id[0] = 1;
                        }

                        array_push(
                            $newCompany,
                            [
                                'user_id' => $company->user_id[0],
                                'alamat_id' => 1,
                                'kode_company' => $company->code,
                                'nama_company' => $company->name,
                                'partner_company' => $company->partner_id[0],
                                'tagline_company' => '(blank)',
                                'external_company_id' => $company->id,
                            ]
                        );
                    }
                }
            }

            if (!empty($newCompany)) {
                DB::table('companies')->insert($newCompany);
                $allDataQty = count($erpCompany);
                echo "updated: $allDataQty Data ";
                return 'success';
            }
        // } catch (Exception $e) {
            // return $e->getMessage();
        // }
    }
}
