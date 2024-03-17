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
            $stocks = $odoo->model('stock.quant')
                ->fields(['id', 'product_id', 'warehouse_id', 'quantity', 'location_id'])
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
                $gudangId = is_array($stock->warehouse_id) ? $stock->warehouse_id[0] : $stock->warehouse_id[0];
                $locationId = is_array($stock->location_id) ? $stock->location_id[0] : $stock->location_id[0];

                $checkStock = DB::table('stok')->where('gudang_id', $gudangId)->where('produk_id', $produkId)->first();
                if ($checkStock) {
                    DB::table('stok')->where('gudang_id', $gudangId)->where('produk_id', $produkId)->update([
                        'jumlah_stok' => $checkStock->jumlah_stok + $stock->quantity
                    ]);
                } else {
                    $dataToInsert[] = [
                        'id' => $stock->id,
                        'produk_id' => $produkId,
                        'gudang_id' => $gudangId,
                        'location_id' => $locationId,
                        'location_id_before' => $locationId,
                        'jumlah_stok' => $stock->quantity,
                        'harga_stok' => '0',
                    ];
                }
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
