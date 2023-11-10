<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show($id)
    {
        // $product = DB::table('produk')
        //     ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
        //     ->select('kategori.*', 'produk.*', 'kategori.id as kid', 'produk.id as pid')
        //     ->where('produk.id', '=', $id)
        //     ->first();
        $stok = DB::table('stok')
            ->join('gudang', 'gudang.id', '=', 'stok.gudang_id')
            ->join('produk', 'produk.id', '=', 'stok.produk_id')
            ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
            ->select(
                'stok.*',
                'kategori.*',
                'produk.*',
                'gudang.*',
                'kategori.id as kid',
                'produk.id as pid',
                'gudang.id as gid',
                'stok.id as sid'
            )
            ->where('stok.id', '=', $id)
            ->first();

        if (!$stok) {
            return response()->json([
                'error' => 'resource not found'
            ], '404');
        }

        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();

        return view('product.show', ['product' => $stok, 'kategoriData' => $kategori]);
    }

    function index()
    {
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.*', 'kategori.id as kid', 'produk.id as pid')
            ->get();

        $res =  response()->json([
            'data' => $products
        ], 200);

        $gudang = DB::table('gudang')
            ->select('nama_gudang', 'id')
            ->get();

        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();

        return view('product.index', ['productsData' => $products, 'kategoriData' => $kategori, 'gudangData' => $gudang]);
    }

    function manage()
    {
        $stok = DB::table('stok')
        ->join('produk', 'produk.id', '=', 'stok.produk_id')
        ->join('gudang', 'gudang.id', '=', 'stok.gudang_id')
        ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
        ->select('stok.*', 'produk.*', 'gudang.*', 'stok.id as sid', 'produk.id as pid', 'gudang.id as gid', 'kategori.id as kid', 'kategori.*')
        ->get();


        return view('product.manage', ['stokData' => $stok]);
    }

    function store(Request $request)
    {
        $validatedData = $request->validate([
            'tb_kode_produk' => 'required',
            'tb_nama_produk' => 'required',
            'tb_desk_produk' => 'required',
            'tb_harga_produk' => 'required',
            'tb_diskon_produk' => 'required',
            'tb_satuan' => 'required',
        ], [
            'tb_kode_produk.required' => 'Kode produk harus diisi',
            'tb_nama_produk.required' => 'Nama produk harus diisi',
            'tb_desk_produk.required' => 'Deskripsi produk harus diisi',
            'tb_harga_produk.required' => 'Harga produk harus diisi',
            'tb_diskon_produk.required' => 'Diskon produk harus diisi',
            'tb_satuan.required' => 'Satuan produk harus diisi',
        ]);
        $product = new Produk;
        $product->kategori_id = $request->cb_kategori;
        $product->kode_produk = $request->tb_kode_produk;
        $product->nama_produk = $request->tb_nama_produk;
        $product->desk_produk = $request->tb_desk_produk;
        $product->harga_produk = $request->tb_harga_produk;
        $product->diskon_produk = $request->tb_diskon_produk;
        $product->satuan_unit_produk = $request->tb_satuan;
        $product->save();

        $stok = new Stok;
        $stok->produk_id = $product->id;
        $stok->gudang_id = $request->cb_gudang_id;
        $stok->jumlah_stok = $request->tb_jumlah_stok;
        $stok->save();

        return redirect()->route('product.manage')->with('success', 'Produk berhasil ditambahkan');
    }

    function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tb_kode_produk' => 'required',
            'tb_nama_produk' => 'required',
            'tb_desk_produk' => 'required',
            'tb_harga_produk' => 'required',

        ], [
            'tb_kode_produk.required' => 'Kode produk harus diisi',
            'tb_nama_produk.required' => 'Nama produk harus diisi',
            'tb_desk_produk.required' => 'Deskripsi produk harus diisi',
            'tb_harga_produk.required' => 'Harga produk harus diisi',
        ]);

        $product = Produk::findOrFail($id);
        // $product = Produk::where('id', '=', $id)->firstOrFail(); // FYI: ini adalah alternate query
        $product->kategori_id = $request->cb_kategori;
        $product->kode_produk = $request->tb_kode_produk;
        $product->nama_produk = $request->tb_nama_produk;
        $product->desk_produk = $request->tb_desk_produk;
        $product->harga_produk = $request->tb_harga_produk;
        $product->save();

        return redirect()->route('product.manage')->with('success', 'Produk berhasil diupdate');
    }

    function delete($id)
    {
        $product = Produk::findOrFail($id);
        $product->delete();
        $stok = Stok::where('produk_id', $id)->first();
        $stok->delete();

        return redirect()->route('product.manage')->with('success', 'Produk berhasil dihapus');
    }

    public function searchProduct(Request $request)
    {
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.*', 'kategori.id as kid', 'produk.id as pid')
            ->where('title', 'LIKE', '%' . $request->search . "%")->get();
        if ($products) {
            return response()->json($products);
        }
    }
}
