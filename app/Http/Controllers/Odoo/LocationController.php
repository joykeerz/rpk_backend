<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\LocationImportJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class LocationController extends Controller
{
    //
    public function importLocation(Odoo $odoo)
    {
        try {
            dispatch(new LocationImportJob($odoo));
            Log::info('Location Import Job Dispatched Successfully');
            return redirect()->back()->with('message', 'Location Import Job Dispatched Successfully');
        } catch (Exception $e) {
            Log::error('Failed to dispatch Location Import Job: ' . $e->getMessage());
            return 'Failed to dispatch Location Import Job';
        }
    }
}
