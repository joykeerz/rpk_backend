<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{
    public function createOrderLine($id, Request $request)
    {
        if (!$request->input()) {
            return response()->json([
                'error' => "please fill data"
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'order_lines.*.product_id' => 'required',
            'order_lines.*.product_uom_qty' => 'required|numeric|min:1',
            'order_lines.*.sh_sec_uom' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        foreach ($request->order_lines as $key => $OrderLine) {
            $newOrderLine = new OrderLine();
            $newOrderLine->sales_order_id = $id;
            $newOrderLine->produk_id = $OrderLine->product_id;
            $newOrderLine->qty_done = $OrderLine->product_uom_qty;
            $newOrderLine->uom = $OrderLine->sh_sec_uom;
            $newOrderLine->save();
        }

        return response()->json([
            'message' => 'Order lines created successfully'
        ], 200);
    }
}
