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
        $categories = Kategori::all();
        // return response()->json([
        //     'data' => $categories,
        // ], '200');
        return view('kategori.index', ['kategoriData' => $categories]);
    }

    public function store(Request $request)
    {
        $category = new Kategori;
        $category->nama_kategori = $request->tb_nama_kategori;
        $category->deskripsi_kategori = $request->tb_desk_kategori;
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
