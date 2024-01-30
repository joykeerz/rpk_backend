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

class BranchImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
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

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        //
        Log::info('Branch Import Job Running');
        $this->importBranch($odoo);
        Log::info('Branch Import Job Finished');
    }
}
