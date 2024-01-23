<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\ImportStockJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class StockController extends Controller
{
    //
    public function importStock(Odoo $odoo)
    {
        try {
            dispatch(new ImportStockJob($odoo));
            Log::info('Stock Import Job Dispatched Successfully');
            return redirect()->route('home')->with('message', 'Product Import Job Dispatched Successfully');
        } catch (Exception $e) {
            Log::error('Failed to dispatch Stock Import Job: ' . $e->getMessage());
            return 'Failed to dispatch Stock Import Job';
        }

        // $pageSize = 100; // Set the desired chunk size

        // $stocks = $odoo->model('stock.quant', 'product.product', 'product.template')
        //     ->fields(['id', 'product_id', 'warehouse_id', 'location_id', 'quantity'])
        //     ->where('location_id', '!=', 5)
        // ->where('warehouse_id', '=', 1)
        // ->where('quantity', '>', 0)
        // ->limit(1000)
        // ->get();
        // dd($stocks);
        // $chunkedStocks = array_chunk($stocks, $pageSize);

        // foreach ($chunkedStocks as $chunk) {
        //     $dataToInsert = [];

        //     foreach ($chunk as $stock) {
        //         $produkId = is_array($stock->product_id) ? $stock->product_id[0] : 1;
        //         $gudangId = is_array($stock->warehouse_id) ? $stock->warehouse_id[0] : 1;

        //         $dataToInsert[] = [
        //             'id' => $stock->id,
        //             'produk_id' => $produkId,
        //             'gudang_id' => $gudangId,
        //             'jumlah_stok' => $stock->quantity,
        //             'harga_stok' => '0',
        //         ];
        //     }

        //     if (!empty($dataToInsert)) {
        //         DB::table('stok')->upsert($dataToInsert, ['id'], ['jumlah_stok']);
        //     }
        // }

        // return dd($stocks);
    }
}
