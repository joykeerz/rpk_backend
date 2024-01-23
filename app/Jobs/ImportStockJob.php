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

class ImportStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function importStock(Odoo $odoo)
    {
        Log::info('Stock Import Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $stocks = $odoo->model('stock.quant', 'product.product', 'product.template')
                ->fields(['id', 'product_id', 'warehouse_id', 'quantity'])
                ->where('location_id', '!=', 5)
                ->where('quantity', '>', 0)
                ->offset($offset)
                ->limit($pageSize)
                ->get();
            Log::info('Stock data retrieved from erp');

            $dataToInsert = [];

            Log::info('looping through stock data');
            foreach ($stocks as $stock) {
                $produkId = is_array($stock->product_id) ? $stock->product_id[0] : 1;
                $gudangId = is_array($stock->warehouse_id) ? $stock->warehouse_id[0] : 1;

                $dataToInsert[] = [
                    'id' => $stock->id,
                    'produk_id' => $produkId,
                    'gudang_id' => $gudangId,
                    'jumlah_stok' => $stock->quantity,
                    'harga_stok' => '0',
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting stock data to database');
                $this->insertData($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($stocks));

        Log::info('Stock Import Job Finished');
    }

    private function insertData(array $dataToInsert)
    {
        DB::table('stok')->upsert($dataToInsert, ['id'], ['jumlah_stok']);
    }


    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->importStock($odoo);
    }
}
