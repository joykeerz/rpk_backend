<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->join('satuan_unit', 'produk.satuan_unit_id', '=', 'satuan_unit.id')
            ->select('stok.*', 'satuan_unit.satuan_unit_produk',  'produk.*', 'gudang.*', 'kategori.*', 'alamat.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'kategori.id as kid', 'alamat.id as aid', 'stok.created_at as cat')
            ->when($request->from, function ($query) use ($request) {
                $query->whereBetween('stok.created_at', [$request->from, $request->to]);
            })
            ->orderBy('stok.created_at', 'desc')
            ->get();

        return view('reporting.stok', ['stocks' => $stocks]);
    }

    public function reportPenjualan(Request $request)
    {
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'transaksi.pesanan_id', '=', 'pesanan.id')
            ->join('alamat', 'pesanan.alamat_id', '=', 'alamat.id')
            ->join('users', 'pesanan.user_id', '=', 'users.id')
            ->join('kurir', 'pesanan.kurir_id', '=', 'kurir.id')
            ->join('biodata', 'users.id', '=', 'biodata.user_id')
            ->select('transaksi.*', 'pesanan.*', 'alamat.*', 'users.*', 'kurir.*', 'biodata.*', 'transaksi.id as tid', 'pesanan.id as pid', 'alamat.id as aid', 'users.id as uid', 'kurir.id as kid', 'biodata.id as bid', 'transaksi.created_at as cat')
            ->when($request->from, function ($query) use ($request) {
                $query->whereBetween('transaksi.created_at', [$request->from, $request->to]);
            })
            ->orderBy('transaksi.created_at', 'desc')
            ->get();

        return view('reporting.penjualan', ['transaksi' => $transaksi]);
    }

    public function exportStok(Request $request)
    {
        $currentDate = date('Y-m-d');
        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('satuan_unit', 'produk.satuan_unit_id', '=', 'satuan_unit.id')
            ->select('stok.*','satuan_unit.satuan_unit_produk', 'produk.*', 'gudang.*', 'kategori.*', 'alamat.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'kategori.id as kid', 'alamat.id as aid', 'stok.created_at as cat')
            ->when($request->from, function ($query) use ($request) {
                $query->whereBetween('stok.created_at', [$request->from, $request->to]);
            })
            ->orderBy('stok.created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('reporting.exportStok', ['stocks' => $stocks, 'from' => $request->from, 'to' => $request->to, 'currentDate' => $currentDate])->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan Stok ' . now() . '.pdf');
    }

    public function exportPenjualan(Request $request)
    {
        $currentDate = date('Y-m-d');
        $transaksi = DB::table('transaksi')
            ->join('pesanan', 'transaksi.pesanan_id', '=', 'pesanan.id')
            ->join('alamat', 'pesanan.alamat_id', '=', 'alamat.id')
            ->join('users', 'pesanan.user_id', '=', 'users.id')
            ->join('kurir', 'pesanan.kurir_id', '=', 'kurir.id')
            ->join('biodata', 'users.id', '=', 'biodata.user_id')
            ->select('transaksi.*', 'pesanan.*', 'alamat.*', 'users.*', 'kurir.*', 'biodata.*', 'transaksi.id as tid', 'pesanan.id as pid', 'alamat.id as aid', 'users.id as uid', 'kurir.id as kid', 'biodata.id as bid', 'transaksi.created_at as cat')
            ->when($request->from, function ($query) use ($request) {
                $query->whereBetween('transaksi.created_at', [$request->from, $request->to]);
            })
            ->orderBy('transaksi.created_at', 'desc')
            ->get();
        // dd($request->from);
        $pdf = Pdf::loadView('reporting.exportPenjualan', ['transaksi' => $transaksi, 'from' => $request->from, 'to' => $request->to, 'currentDate' => $currentDate])->setPaper('a4', 'landscape');
        return $pdf->stream($filename = 'Laporan Penjualan ' . now() . '.pdf');
    }
}
