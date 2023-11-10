<?php

namespace App\Http\Controllers;

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
        $stok = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'alamat.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'company.id as cid')
            ->get();


        $res =  response()->json([
            'data' => $stok,
            'message' => 'stok loaded'
        ], 200);

        return $res;
        // return view('product.index', ['productsData' => $products]);
    }

    public function show($id)
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'company.id as cid')
            ->where('gudang.id', '=', $id)
            ->first();

        if (!$gudang) {
            return response()->json([
                'error' => 'resource not found'
            ], '404');
        }

        $res = response()->json([
            'data' => $gudang,
        ], 200);

        // return view('products.show', ['product' => $product]);
    }

    public function updateFromProduct(Request $request, $id)
    {
        $stok = Stok::select('stok.*', 'gudang.*', 'produk.*')
            ->join('gudang', 'gudang.id', '=', 'stok.gudang_id')
            ->join('produk', 'produk.id', '=', 'stok.produk_id')
            ->where('stok.id', '=', $id)
            ->first();
        // $stok = Stok::where('produk_id',$id)->where('gudang_ud',$request->tb_gudang_id)->first();
        $stok->jumlah_stok = $request->tb_jumlah_stok;
        $stok->save();
        return response()->json([
            'data' => [$stok],
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function increaseStock(Request $request, $id)
    {
        $stok = Stok::select('stok.*')
            ->join('gudang', 'gudang.id', '=', 'stok.gudang_id')
            ->join('produk', 'produk.id', '=', 'stok.produk_id')
            ->where('stok.id', '=', $id)
            ->first();
        $stok->increment('jumlah_stok', $request->tb_jumlah_stok);
        $stok->save();
        $res =  response()->json([
            'data' => $stok,
            'message' => 'stok berhasil diupdate'
        ], '200');

        // return $res;
    }

    public function updateFromGudang(Request $request, $id)
    {
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
