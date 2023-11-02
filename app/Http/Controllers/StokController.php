<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
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

        // foreach ($products as $key => $value) {
        //     echo "$key:$value->nama_produk, ";
        // }
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
        $stok = Stok::where('produk_id',$id)->where('gudang_ud',$request->tb_gudang_id)->first();
        // $gudang = Gudang::findOrFail($id);
        // $gudang->company_id = $request->cb_alamat_id;
        // $gudang->user_id = $request->cb_user_id;
        // $gudang->nama_gudang = $request->tb_kode_produk;
        // $gudang->no_telp = $request->tb_nama_produk;
        // $gudang->save();

        return response()->json([
            'data' => [$stok],
            'message' => 'stok berhasil diupdate'
        ], '200');
    }

    public function updateFromGudang(Request $request, $id) {

    }

    public function delete($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();
        $alamat = Alamat::where('id', $gudang->alamat_id)->delete();
        $alamat->delete();
        $stok = Stok::where('gudang_id', $id);
        $stok->delete();
        // $alamat = Alamat::where('id', $gudang->alamat_id)->delete();

        return response()->json([
            'message' => 'gudang serta alamat dan stok berhasil dihapus'
        ], '200');
    }
}
