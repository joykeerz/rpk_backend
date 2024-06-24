<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\OrderLine;
use App\Models\OutDocument;
use App\Models\Pesanan;
use App\Models\SalesOrder;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SalesOrderController extends Controller
{
    public function createOrderLine($id, Request $request)
    {
        Log::info('API Triggered From ERP');
        // Find the SalesOrder by erp_sale_order_id
        $salesOrder = SalesOrder::where('erp_sale_order_id', $id)->first();

        // If SalesOrder not found, return error response
        if (!$salesOrder) {
            return response()->json([
                'status' => "Error",
                'message' => "Sales Order not found in rpk backend for ID: $id"
            ], 404);
            Log::info('SO Not Found');
        }

        // update out document data By Sale Order Id
        $outDocument = OutDocument::where('sales_order_id', $salesOrder->id)->first();
        if (!$outDocument) {
            return response()->json([
                'status' => "Error",
                'message' => "Error finding out document on RPK Backend"
            ], 404);
            Log::info('SO Not Found');
        }
        $outDocumentId = $outDocument->id;
        $outDocument->plat_number = $request->plat_number;
        $outDocument->driver = $request->driver;
        $outDocument->out_document_status = $request->status;
        $outDocument->save();


        Log::info('Validating Data');
        // Validate request data
        $request->validate([
            'order_lines.*.product_id' => 'required',
            'order_lines.*.qty_done' => 'required',
            'order_lines.*.product_uom' => 'required',
        ]);

        Log::info('Inserting Data');
        // Iterate over each order line and create OrderLine records
        foreach ($request->order_lines as $orderLineData) {
            $newOrderLine = new OrderLine();
            $newOrderLine->sales_order_id = $salesOrder->id;
            $newOrderLine->produk_id = $orderLineData['product_id'];
            $newOrderLine->qty_done = $orderLineData['qty_done'];
            $newOrderLine->uom = $orderLineData['product_uom'];
            $newOrderLine->scheduled_date = $request->scheduled_date;
            $newOrderLine->plat_number = $request->plat_number;
            $newOrderLine->driver = $request->driver;
            $newOrderLine->ordered_quantity = $orderLineData['qty_ordered'];
            $newOrderLine->secondary_quantity = $orderLineData['scondary_qty'];
            $newOrderLine->secondary_quantity_done = $orderLineData['secondary_qty_done'];
            $newOrderLine->out_document_id = $outDocumentId;
            $newOrderLine->save();
        }

        Log::info('Updating Status');
        // Update related models (example: update Pesanan status)
        $transaksi = Transaksi::find($salesOrder->transaksi_id);
        if ($transaksi) {
            $pesanan = Pesanan::find($transaksi->pesanan_id);
            if ($pesanan && $pesanan->status_pemesanan != 'dikirim') {
                $pesanan->status_pemesanan = 'dikirim';
                $pesanan->save();
            }
        }

        Log::info('Update Successful');
        // Return success response
        return response()->json([
            'status' => 'Success',
            'message' => 'Order lines created successfully'
        ], 200);
    }
}
