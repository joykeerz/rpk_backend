<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->select('gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid', 'gudang.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();

        $stok = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->orderBy('stok.created_at', 'desc')
            ->get();

        // $gudangStockCount = [];
        // foreach ($gudang as $g) {
        //     foreach($stok as $s) {
        //         if ($g->gid == $s->gid) {
        //             array_push($gudangStockCount, [
        //                 'gudang' => $g,
        //                 'stok' => $s
        //             ])
        //         };
        //     };
        // };

        // return $gudangStockCount;

        return view('stock.index', ['gudang' => $gudang, 'stok' => $stok]);
    }

    public function stockByGudang($id)
    {
        $gudang = Gudang::findOrFail($id);
        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->where('stok.gudang_id', '=', $id)
            ->orderBy('stok.created_at', 'desc')
            ->get();

        // $res = response()->json([
        //     'data' => $stok
        // ], 200);

        // return $res;

        return view('stock.showByGudang', ['gudang' => $gudang, 'stocks' => $stocks]);
    }

    public function stokByProduct($id)
    {
        $stock = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->where('stok.produk_id', '=', $id)
            ->orderBy('stok.created_at', 'desc')
            ->get();

        $res = response()->json([
            'data' => $stock
        ], 200);

        return $res;
    }


    public function showStock($id)
    {
        $stock = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'stok.created_at as cat')
            ->where('stok.id', '=', $id)
            ->first();

        return response()->json([
            'data' => $stock,
            'message' => 'stok berhasil ditambahkan'
        ], '200');
        // return view('products.show', ['product' => $product]);
    }

    public function createStock(Request $request, $id)
    {
        $stock = Stok::create([
            'produk_id' => $id,
            'gudang_id' => $request->cb_gudang_id,
            'jumlah_stok' => $request->tb_jumlah_stok
        ]);

        return response()->json([
            'data' => $stock,
            'message' => 'stok berhasil ditambahkan'
        ], '200');
    }

    public function updateJumlahStock(Request $request, $id)
    {
        $stok = Stok::findOrfail($id);
        $stok->jumlah_stok = $request->tb_jumlah_stok;
        $stok->save();
        return response()->json([
            'data' => [$stok],
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function increaseStock(Request $request, $id)
    {
        $stok = Stok::findOrfail($id);
        $stok->increment('jumlah_stok', $request->tb_jumlah_stok);
        $stok->save();
        $res =  response()->json([
            'data' => $stok,
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function decreaseStock(Request $request, $id)
    {
        $stok = Stok::findOrfail($id);
        $stok->decrement('jumlah_stok', $request->tb_jumlah_stok);
        $stok->save();
        $res =  response()->json([
            'data' => $stok,
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function delete($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return response()->json([
            'message' => 'stok berhasil dihapus'
        ], '200');
    }
}
