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

class LocationImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function importLocation(Odoo $odoo)
    {
        Log::info('Location Import Job Running');

        $pageSize = 100; // Set the desired chunk size
        $offset = 0;

        do {
            $locations = $odoo->model('stock.location')
                ->fields(['id', 'warehouse_id', 'display_name', 'location_id', 'is_stock_unique_many_product'])
                // ->where('company_id', '!=', false)
                ->where('usage', '=', 'internal')
                ->where('warehouse_id', '!=', false)
                ->limit($pageSize)
                ->offset($offset)
                ->get();
            Log::info("Location data retrieved from erp : " . $offset);

            $dataToInsert = [];

            Log::info('looping through location data');
            foreach ($locations as $location) {
                $is_stock_unique_many_product = $location->is_stock_unique_many_product ? $location->is_stock_unique_many_product : 'none';
                $dataToInsert[] = [
                    'id' => $location->id,
                    'gudang_id' => $location->warehouse_id[0],
                    'location_name' => $location->display_name,
                    'parent_location' => $location->location_id[0],
                    'unique_or_many' => $is_stock_unique_many_product,
                ];
            }

            if (!empty($dataToInsert)) {
                Log::info('inserting stock data to database :' . $offset);
                $this->insertData($dataToInsert);
            }

            $offset += $pageSize;
        } while (!empty($locations));
        Log::info('Location Import function Finished');
    }

    public function insertData(array $dataToInsert)
    {
        DB::table('locations')->upsert($dataToInsert, ['id'], ['gudang_id', 'location_name', 'parent_location', 'unique_or_many']);
    }
    /**
     * Execute the job.
     */
    public function handle(Odoo $odoo): void
    {
        $this->importLocation($odoo);
    }
}
