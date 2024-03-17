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

class PriceImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function importPrice(Odoo $odoo)
    {
        Log::info('Running Price Import function');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $stocks = $odoo->model('stock.quant')
                ->fields(['id', 'product_id', 'company_id'])
                ->where('location_id', '!=', 5)
                // ->where('warehouse_id', '!=', false)
                ->where('quantity', '>', 0)
                ->where('product_id.type', '=', 'product')
                ->where('location_id.usage', '=', 'internal')
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Stock data retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through stock data');
            foreach ($stocks as $stock) {
                $produkId = is_array($stock->product_id) ? $stock->product_id[0] : $stock->product_id[0];
                $companyId = is_array($stock->company_id) ? $stock->company_id[0] : $stock->company_id[0];
                $Produk = $odoo->model('product.product')->fields(['lst_price'])->where('id', '=', $produkId)->first();

                $dataToInsert[] = [
                    'id' => $stock->id,
                    'produk_id' => $produkId,
                    'company_id' => $companyId,
                    'price_value' => $Produk->lst_price,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting price data to database');
                $this->insertData($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($stocks));

        Log::info('Price Import Job Finished');
    }

    private function insertData(array $dataToInsert)
    {
        DB::table('prices')->upsert($dataToInsert, ['id'], ['price_value']);
    }

    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        //
        Log::info('Price Import Job Running');
        $this->importPrice($odoo);
        Log::info('Price Import Job Finished');
    }
}
