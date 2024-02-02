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

class CompanyBranchImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function importCompany(Odoo $odoo)
    {
        Log::info('Fetching company data from ERP...');
        $erpCompany = $odoo->model('res.company')->fields(['id', 'code', 'name', 'partner_id', 'user_id', 'street', 'zip'])->get();

        Log::info('Looping through company data...');
        foreach ($erpCompany as $company) {
            if (!DB::table('companies')->where('id', $company->id)->exists()) {
                $insertAlamatGetId = DB::table('alamat')->insertGetId([
                    'jalan' => $company->street,
                    'provinsi' =>   '(blank)',
                    'kota_kabupaten' => '(blank)',
                    'kecamatan' => '(blank)',
                    'negara' => '(blank)',
                    'kode_pos' => $company->zip,
                ]);
            } else {
                $insertAlamatGetId = DB::table('companies')->where('id', $company->id)->value('alamat_id');
            }

            if ($company->user_id === false) {
                $company->user_id = [$company->user_id];
                $company->user_id[0] = 1;
            }

            $insertCompanyGetId = DB::table('companies')->updateOrInsert(['id' => $company->id], [
                'id' => $company->id,
                // 'user_id' => $company->user_id[0],
                'alamat_id' => $insertAlamatGetId,
                'kode_company' => $company->code,
                'nama_company' => $company->name,
                'partner_company' => 'none',
                'tagline_company' => 'none',
            ]);
        }
    }

    public function importBranch(Odoo $odoo)
    {
        Log::info('Fetching branch data from ERP...');
        $odooBranch = $odoo->model('res.branch')->fields(['id', 'name', 'address', 'company_id'])->get();
        Log::info('Looping through branch data...');
        foreach ($odooBranch as $branch) {
            DB::table('branches')->updateOrInsert(['id' => $branch->id], [
                'id' => $branch->id,
                'company_id' => $branch->company_id[0],
                'nama_branch' => $branch->name,
                'no_telp_branch' => '-',
                'alamat_branch' => $branch->address,
            ]);
        }
    }

    public function handle(Odoo $odoo): void
    {
        Log::info('Starting company import job...');
        $this->importCompany($odoo);
        Log::info('Company import job finished.');


        Log::info('Starting branch import job...');
        $this->importBranch($odoo);
        Log::info('branch import job finished.');
    }
}
