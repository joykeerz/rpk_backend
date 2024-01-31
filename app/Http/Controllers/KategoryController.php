<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $categories = Kategori::paginate(15);
        // return response()->json([
        //     'data' => $categories,
        // ], '200');
        return view('kategori.index', ['kategoriData' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tb_nama_kategori' => 'required',
            'tb_desk_kategori' => 'required',
        ], [
            'tb_nama_kategori.required' => 'Nama Kategori Harus Diisi!',
            'tb_desk_kategori.required' => 'Deskripsi Kategori Harus Diisi!',
        ]);

        $category = new Kategori;
        $category->id = Kategori::max('id') + 1;
        $category->nama_kategori = $request->tb_nama_kategori;
        $category->deskripsi_kategori = $request->tb_desk_kategori;
        $category->external_kategori_id = $request->tb_external_id;
        $category->save();
        // return response()->json([
        //     'data' => $category,
        // ], '200');
        return redirect()->route('category.index')->with('message', 'Data Kategori Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        $category = Kategori::findOrFail($id);
        return response()->json([
            'data' => $category,
        ], '200');
    }

    public function update(Request $request, $id)
    {
        $category = Kategori::find($id);
        $category->nama_kategori = $request->tb_nama_kategori;
        $category->deskripsi_kategori = $request->tb_desk_kategori;
        $category->external_kategori_id = $request->tb_external_kategori_id;
        $category->save();
        return response()->json([
            'data' => $category,
        ], '200');
    }

    public function delete($id)
    {
        Produk::where('kategori_id', $id)
            ->update(['kategori_id' => 1]);
        $category = Kategori::findOrFail($id);
        $category->delete();
        // return response()->json([
        //     'message' => "{$category} berhasil dihapus",
        // ], '200');

        return redirect()->route('category.index')->with('message', 'Data Kategori Berhasil Dihapus!');
    }
}
