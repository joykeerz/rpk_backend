<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\BranchImportJob;
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
            dispatch(new BranchImportJob($odoo));
            Log::info('Branch Import Job Dispatched Successfully');
            return redirect()->route('branch.manage')->with('message', 'Branch Import Job Dispatched Successfully');
        } catch (Exception $e) {
            Log::error('Failed to dispatch gudang Import Job: ' . $e->getMessage());
            return 'Failed to dispatch gudang Import Job';
        }
    }
}
