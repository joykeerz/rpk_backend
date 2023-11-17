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
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('kategori.*', 'produk.*', 'kategori.id as kid', 'produk.id as pid', 'produk.created_at as cat')
            ->where('produk.id', '=', $id)
            ->orderBy('cat', 'desc')
            ->first();

        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();

        return view('product.show', ['product' => $products, 'kategoriData' => $kategori]);
    }

    function index()
    {
        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();
        return view('product.index', ['kategoriData' => $kategori]);
    }

    function manage(Request $request)
    {
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.*', 'kategori.id as kid', 'produk.id as pid', 'produk.created_at as cat')
            ->orderBy('cat', 'desc')
            ->get();



        // $products = DB::table('produk')
        //     ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
        //     ->select('kategori.*', 'produk.*', 'kategori.id as kid', 'produk.id as pid', 'produk.created_at as cat')
        //     ->when($request->keyword, function ($query) use ($request) {
        //         $query->where('nama_produk', 'like', "%{$request->keyword}%");
        //     })
        //     ->orderBy('cat', 'desc')
        //     ->paginate(10);

        return view('product.manage', ['products' => $products]);
    }

    function store(Request $request)
    {
        $validatedData = $request->validate([
            'tb_kode_produk' => 'required',
            'tb_nama_produk' => 'required',
            'tb_desk_produk' => 'required',
            'tb_harga_produk' => 'required',
            'tb_satuan' => 'required',
        ], [
            'tb_kode_produk.required' => 'Kode produk harus diisi',
            'tb_nama_produk.required' => 'Nama produk harus diisi',
            'tb_desk_produk.required' => 'Deskripsi produk harus diisi',
            'tb_harga_produk.required' => 'Harga produk harus diisi',
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

        return redirect()->route('product.manage')->with('success', 'Produk berhasil dihapus');
    }

    public function searchProduct(Request $request)
    {
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.*', 'kategori.id as kid', 'produk.id as pid')
            ->where('title', 'LIKE', '%' . $request->search . "%")->get();

        if (!$products) {
            return response()->json([
                'error' => 'resource not found'
            ], '404');
        }

        return response()->json([
            'data' => $products,
        ], 200);
    }
}
