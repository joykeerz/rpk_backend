<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'companies.id as cid')
            ->get();

        $res =  response()->json([
            'data' => $gudang
        ], 200);



        // foreach ($products as $key => $value) {
        //     echo "$key:$value->nama_produk, ";
        // }
        //return $res;
        return view('gudang.index', ['gudangData' => $gudang]);

    }

    public function store(Request $request)
    {

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_ext;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_prov;
        $alamat->kota_kabupaten = $request->tb_kota;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        $gudang = new Gudang;
        $gudang->alamat_id = $alamat->id;
        $gudang->company_id = $request->cb_alamat_id;
        $gudang->user_id = $request->cb_user_id;
        $gudang->nama_gudang = $request->tb_kode_produk;
        $gudang->no_telp = $request->tb_nama_produk;
        $gudang->save();

        return response()->json([
            'data' => [$alamat, $gudang],
            'message' => 'gudang berhasil didaftarkan',
        ], '200');
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

    public function update(Request $request, $id)
    {

        $gudang = Gudang::findOrFail($id);
        $gudang->company_id = $request->cb_alamat_id;
        $gudang->user_id = $request->cb_user_id;
        $gudang->nama_gudang = $request->tb_kode_produk;
        $gudang->no_telp = $request->tb_nama_produk;
        $gudang->save();

        $alamat = Alamat::findOrFail($gudang->alamat_id);
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_ext;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_prov;
        $alamat->kota_kabupaten = $request->tb_kota;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        return response()->json([
            'data' => [$gudang, $alamat],
            'message' => 'gudang berhasil diupdate'
        ], '200');
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

    public function searchGudang(Request $request)
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'company.id as cid')
            ->where('title', 'LIKE', '%' . $request->search . "%")->get();
        if ($gudang) {
            return response()->json($gudang);
        }
    }
}
