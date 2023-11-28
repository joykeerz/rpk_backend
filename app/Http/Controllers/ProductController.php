<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            ->join('pajak', 'produk.pajak_id', '=', 'pajak.id')
            ->join('satuan_unit', 'produk.satuan_unit_id', '=', 'satuan_unit.id')
            ->select('kategori.*', 'produk.*', 'pajak.*', 'satuan_unit.*', 'kategori.id as kid', 'produk.id as pid', 'pajak.id as pjid', 'satuan_unit.id as suid', 'produk.created_at as cat')
            ->where('produk.id', '=', $id)
            ->orderBy('cat', 'desc')
            ->first();

        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();

        $pajak = DB::table('pajak')
            ->select('pajak.*')
            ->get();

        $satuan = DB::table('satuan_unit')
            ->select('satuan_unit.*')
            ->get();

        return view('product.show', ['product' => $products, 'kategoriData' => $kategori, 'pajakData' => $pajak, 'satuanData' => $satuan]);
    }

    function index()
    {
        $kategori = DB::table('kategori')
            ->select('nama_kategori', 'id')
            ->get();

        $pajak = DB::table('pajak')
            ->select('pajak.*')
            ->get();

        $satuan = DB::table('satuan_unit')
            ->select('satuan_unit.*')
            ->get();

        return view('product.index', ['kategoriData' => $kategori, 'pajakData' => $pajak, 'satuanData' => $satuan]);
    }

    function manage(Request $request)
    {
        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('pajak', 'produk.pajak_id', '=', 'pajak.id')
            ->join('satuan_unit', 'produk.satuan_unit_id', '=', 'satuan_unit.id')
            ->select('produk.*', 'kategori.*', 'kategori.id as kid', 'produk.id as pid', 'produk.created_at as cat')
            ->orderBy('cat', 'desc')
            ->paginate(15);

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
            'tb_satuan' => 'required',
            'cb_kategori' => 'required',
            'file_image_produk' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tb_pajak' => 'required',
        ], [
            'tb_kode_produk.required' => 'Kode produk harus diisi',
            'tb_nama_produk.required' => 'Nama produk harus diisi',
            'tb_desk_produk.required' => 'Deskripsi produk harus diisi',
            'tb_satuan.required' => 'Satuan produk harus diisi',
            'cb_kategori.required' => 'Kategori harus diisi',
            'file_image_produk.image' => 'File harus berupa gambar',
            'file_image_produk.mimes' => 'File harus berupa gambar',
            'file_image_produk.max' => 'Ukuran file maksimal 2MB',
            'tb_pajak.required' => 'Pajak harus diisi',
        ]);

        $product = new Produk;
        $product->kategori_id = $request->cb_kategori;
        $product->pajak_id = $request->tb_pajak;
        $product->satuan_unit_id = $request->tb_satuan;
        $product->kode_produk = $request->tb_kode_produk;
        $product->nama_produk = $request->tb_nama_produk;
        $product->desk_produk = $request->tb_desk_produk;
        $product->diskon_produk = $request->tb_diskon_produk;
        $product->external_produk_id = $request->tb_external_id;
        if ($request->hasFile('file_image_produk')) {
            // $file = $request->file('file_image_produk');
            // $file->move(public_path().'/images/', $fileName);
            // $fileName = time().'_'.$file->getClientOriginalName();
            // $productFiles = new ProductFile;
            // $productFiles->file_name = $fileName;
            // $productFiles->save();

            $filePath = $request->file('file_image_produk')->store('images/product', 'public');
            $validatedData['file_image_produk'] = $filePath;
            $productFiles = new ProductFile;
            $productFiles->file_name = $filePath;
            $productFiles->save();
        }
        $product->product_file_id = $productFiles->id;
        $product->produk_file_path = $filePath;
        $product->save();

        return redirect()->route('product.manage')->with('message', 'Produk berhasil ditambahkan');
    }

    function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tb_kode_produk' => 'required',
            'tb_nama_produk' => 'required',
            'tb_desk_produk' => 'required',
            'tb_satuan' => 'required',
            'cb_kategori' => 'required',
            'file_image_produk' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tb_pajak' => 'required',
        ], [
            'tb_kode_produk.required' => 'Kode produk harus diisi',
            'tb_nama_produk.required' => 'Nama produk harus diisi',
            'tb_desk_produk.required' => 'Deskripsi produk harus diisi',
            'tb_satuan.required' => 'Satuan produk harus diisi',
            'cb_kategori.required' => 'Kategori harus diisi',
            'file_image_produk.image' => 'File harus berupa gambar',
            'file_image_produk.mimes' => 'File harus berupa gambar',
            'file_image_produk.max' => 'Ukuran file maksimal 2MB',
            'tb_pajak.required' => 'Pajak harus diisi',
        ]);

        $product = Produk::findOrFail($id);
        // $product = Produk::where('id', '=', $id)->firstOrFail(); // FYI: ini adalah alternate query
        $product->kategori_id = $request->cb_kategori;
        $product->pajak_id = $request->tb_pajak;
        $product->satuan_unit_id = $request->tb_satuan;
        $product->kode_produk = $request->tb_kode_produk;
        $product->nama_produk = $request->tb_nama_produk;
        $product->desk_produk = $request->tb_desk_produk;
        $product->external_produk_id = $request->tb_external_id;
        $product->diskon_produk = $request->tb_diskon_produk;

        if ($request->hasFile('file_image_produk')) {
            $filePath = $request->file('file_image_produk')->store('images/product', 'public');
            $validatedData['file_image_produk'] = $filePath;
            if (!empty($product->produk_file_path)) {
                Storage::disk('public')->delete($product->produk_file_path);
            }
            $productFiles = ProductFile::find($product->product_file_id);
            if (!$productFiles) {
                $productFiles = new ProductFile;
                $productFiles->file_name = $filePath;
                $productFiles->save();
            } else {
                $productFiles->file_name = $filePath;
                $productFiles->save();
            }
            $product->produk_file_path = $filePath;
        }
        $product->save();

        return redirect()->route('product.manage')->with('message', 'Produk berhasil diupdate');
    }

    function delete($id)
    {
        $product = Produk::findOrFail($id);
        Storage::disk('public')->delete($product->produk_file_path);
        $productFiles = ProductFile::findOrFail($product->product_file_id);
        if ($productFiles->file_name != null) {
            $productFiles->delete();
        }

        $stock = Stok::where('produk_id', '=', $id)->delete();
        $product->delete();

        return redirect()->route('product.manage')->with('message', 'Produk berhasil dihapus');
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
