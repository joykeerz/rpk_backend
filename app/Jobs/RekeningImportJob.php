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

class RekeningImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    public function syncRekening(Odoo $odoo)
    {
        Log::info('Rekening Sync Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $rekenings = $odoo->model('account.journal')
                ->fields(['id', 'branch_owner_id', 'company_id', 'display_name', 'name', 'bank_acc_number'])
                ->where('is_xendit_payment', '=', true)
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Rekening data retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through Rekening data');
            foreach ($rekenings as $rekening) {
                $dataToInsert[] = [
                    'id' => $rekening->id,
                    'branch_id' => $rekening->branch_owner_id ? $rekening->branch_owner_id[0] : false,
                    'company_id' => $rekening->company_id[0],
                    'display_name' => $rekening->display_name,
                    'name' => $rekening->name,
                    'bank_acc_number' => $rekening->bank_acc_number,
                    'isActive' => false,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting Rekening data to database :' . $offset);
                $this->insertData($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($rekenings));

        Log::info('Rekening Sync Job Finished');
    }

    private function insertData(array $dataToInsert)
    {
        DB::table('rekening_tujuan')->upsert($dataToInsert, ['id'], ['bank_acc_number']);
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->syncRekening($odoo);
    }
}
