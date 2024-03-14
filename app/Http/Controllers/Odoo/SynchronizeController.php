<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\CompanyBranchImportJob;
use App\Jobs\GudangImportJob;
use App\Jobs\ImportStockJob;
use App\Jobs\PartnerImportJob;
use App\Jobs\PriceImportJob;
use App\Jobs\ProductImportJob;
use App\Jobs\UserImportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class SynchronizeController extends Controller
{
    public function synchronizeAll(Odoo $odoo)
    {
        try {
            dispatch(new ProductImportJob($odoo));
            Log::info('Product Import Job Dispatched Successfully');

            dispatch(new UserImportJob($odoo));
            Log::info('Manager Sales Import Job Dispatched Successfully');

            dispatch(new CompanyBranchImportJob($odoo));
            Log::info('Company Import Job Dispatched Successfully');

            dispatch(new GudangImportJob($odoo));
            Log::info('gudang Import Job Dispatched Successfully');

            dispatch(new PartnerImportJob($odoo));
            Log::info('Partner Import Job Dispatched Successfully');

            dispatch(new ImportStockJob($odoo));
            Log::info('Stok Import Job Dispatched Successfully');

            dispatch(new PriceImportJob($odoo));
            Log::info('Price Import Job Dispatched Successfully');

            return redirect()->route('home')->with('Message', 'Synchronize All Data Successfuly running in background');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function syncDebug(Odoo $odoo)
    {
        // $data = $odoo->model('product.product')->fields(['name', 'display_name', 'categ_id', 'uom_id', 'default_code'])->limit(5)->get();
        $data = $odoo->model('stock.quant')
            // ->fields(['id', 'product_id', 'warehouse_id', 'quantity'])
            ->where('location_id', '!=', 5)
            // ->where('warehouse_id', '!=', false)
            ->where('quantity', '>', 0)
            ->where('product_id.type', '=', 'product')
            ->where('location_id.usage', '=', 'internal')
            ->limit(1)
            ->get();
        dd($data);
    }
}
