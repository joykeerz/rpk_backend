<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\CompanyBranchImportJob;
use App\Jobs\DaerahSyncJob;
use App\Jobs\GudangImportJob;
use App\Jobs\ImportStockJob;
use App\Jobs\LocationImportJob;
use App\Jobs\PartnerImportJob;
use App\Jobs\PaymentTermImportJob;
use App\Jobs\PriceImportJob;
use App\Jobs\ProductImportJob;
use App\Jobs\RekeningImportJob;
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

            dispatch(new LocationImportJob($odoo));
            Log::info('Location Import Job Dispatched Successfully');

            dispatch(new RekeningImportJob($odoo));
            Log::info('Rekening Sync Job Dispatched Successfully');

            dispatch(new PaymentTermImportJob($odoo));
            Log::info('Payment Terms Sync Job Dispatched Successfully');

            return redirect()->route('home')->with('Message', 'Synchronize All Data Successfuly running in background');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function syncDebug(Odoo $odoo)
    {
        // $soFromErp = $odoo->model('sale.order')->where('id', '=', 998151)->first();
        // $orderLineDetail = $odoo->model('sale.order.line')->where('id', '=', 1153666)->first();
        // $stockPicking = $odoo->model('stock.picking')->where('sale_id', '=', 998151)->first();
        // $jenisPartner = $odoo->model('jenis.partner')->get();
        // dd($soFromErp, $orderLineDetail, $stockPicking, $jenisPartner);
        // dispatch(new DaerahSyncJob($odoo));
        // Log::info('Daerah Job Dispatched Successfully');
        // return redirect()->route('home')->with('Message', 'Synchronize All Data Successfuly running in background');

        // $kecamatan  = $odoo->model('res.kecamatan')->limit(20)->get();
        // dd($kecamatan);

        // $kecamatan  = $odoo->model('sale.order')->where('id','=','1389700')->first();
        // $picking  = $odoo->model('stock.picking')->where('id','=','2235289')->first();
        // dd($kecamatan,$picking);
    }
}
