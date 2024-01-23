<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\CompanyBranchImportJob;
use App\Jobs\GudangImportJob;
use App\Jobs\PartnerImportJob;
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

            return redirect()->route('home')->with('Message', 'Synchronize All Data Successfuly running in background');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
