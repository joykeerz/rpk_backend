<?php

namespace App\Http\Controllers\Odoo;

use App\Http\Controllers\Controller;
use App\Jobs\PriceImportJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Obuchmann\OdooJsonRpc\Odoo;

class PriceController extends Controller
{
    //
    public function importPrice(Odoo $odoo)
    {
        // $price = $odoo->model('product.product')->fields(['id', 'name', 'categ_id', 'uom_id', 'default_code', 'lst_price', 'list_price'])->limit(50)->get();
        // $price = $odoo->model('product.pricelist')->where('id', '=', 288)->limit(5)->get();

        // dd($price);
        try {
            dispatch(new PriceImportJob($odoo));
            Log::info('Price Import Job Dispatched Successfully');
            return redirect()->route('home')->with('message', 'Price Import Job Dispatched Successfully');
        } catch (Exception $e) {
            Log::error('Failed to dispatch price Import Job: ' . $e->getMessage());
            return 'Failed to dispatch price Import Job';
        }
    }
}
