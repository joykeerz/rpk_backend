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

class PaymentTermImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function syncPaymentTerm(Odoo $odoo)
    {
        Log::info('Payment Term Sync Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $paymentTerms = $odoo->model('stock.quant')
                ->fields(['id', 'company_id', 'name', 'tipe_penjualan'])
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Rekening data retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through Rekening data');
            foreach ($paymentTerms as $paymentTerm) {
                $dataToInsert[] = [
                    'id' => $paymentTerm->id,
                    'company_id' => $paymentTerm->company_id[0],
                    'name' => $paymentTerm->name,
                    'tipe_penjualan' => $paymentTerm->tipe_penjualan,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting Rekening data to database :' . $offset . '-' . $pageSize);
                $this->insertData($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($rekenings));

        Log::info('Rekening Sync Job Finished');
    }

    private function insertData(array $dataToInsert)
    {
        DB::table('payment_terms')->upsert($dataToInsert, ['id'], ['name', 'tipe_penjualan']);
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->syncPaymentTerm($odoo);
    }
}
