<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\CompanyBranchImportJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class BranchController extends Controller
{
    public function importFromErp(Odoo $odoo)
    {
        try {
            dispatch(new CompanyBranchImportJob($odoo));
            Log::info('gudang Import Job Dispatched Successfully');
            return 'gudang Import Job dispatched successfully';
        } catch (Exception $e) {
            Log::error('Failed to dispatch gudang Import Job: ' . $e->getMessage());
            return 'Failed to dispatch gudang Import Job';
        }
    }
}
