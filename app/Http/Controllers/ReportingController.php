<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reportStockByGudang()
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();
        return $gudang;
        // return view('reporting.stok', ['stok' => $stock, 'gudang' => $gudang]);
    }

    public function reportStockAll(Request $request)
    {
        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'kategori.*', 'alamat.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'kategori.id as kid', 'alamat.id as aid', 'stok.created_at as cat')
            ->when($request->keyword, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->from, $request->to]);
            })
            ->orderBy('stok.created_at', 'desc')
            ->get();

        return view('reporting.stok', ['stocks' => $stocks]);
    }

    public function reportPenjualan()
    {
    }
}
