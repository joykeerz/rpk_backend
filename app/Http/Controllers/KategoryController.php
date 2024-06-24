<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\CategoryFile;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validatedData = $request->validate([
            'tb_nama_kategori' => 'required',
            'tb_desk_kategori' => 'required',
            'file_icon_kategori' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tb_nama_kategori.required' => 'Nama Kategori Harus Diisi!',
            'tb_desk_kategori.required' => 'Deskripsi Kategori Harus Diisi!',
            'file_icon_kategori.image' => 'File harus berupa gambar',
            'file_icon_kategori.mimes' => 'File harus berupa gambar',
            'file_icon_kategori.max' => 'Ukuran file maksimal 2MB',
        ]);

        $category = new Kategori;
        $category->id = Kategori::max('id') + 1;
        $category->nama_kategori = $request->tb_nama_kategori;
        $category->deskripsi_kategori = $request->tb_desk_kategori;
        $category->external_kategori_id = $request->tb_external_id;
        if ($request->hasFile('file_icon_kategori')) {
            // reference from ProductController

            $filePath = $request->file('file_icon_kategori')->store('images/category', 'public');
            $validatedData['file_icon_kategori'] = $filePath;
            $categoryFiles = new CategoryFile;
            $categoryFiles->file_name = $filePath;
            $categoryFiles->save();
            $category->category_file_id = $categoryFiles->id;
            $category->category_file_path = $filePath;
        }
        $category->save();
        // return response()->json([
        //     'data' => $category,
        // ], '200');
        return redirect()->route('category.index')->with('message', 'Data Kategori Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        $category = Kategori::findOrFail($id);

        return view('kategori.show', ['kategori' => $category]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tb_nama_kategori' => 'required',
            'tb_desk_kategori' => 'required',
            'file_icon_kategori' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tb_nama_kategori.required' => 'Nama Kategori Harus Diisi!',
            'tb_desk_kategori.required' => 'Deskripsi Kategori Harus Diisi!',
            'file_icon_kategori.image' => 'File harus berupa gambar',
            'file_icon_kategori.mimes' => 'File harus berupa gambar',
            'file_icon_kategori.max' => 'Ukuran file maksimal 2MB',
        ]);
        $category = Kategori::find($id);
        if ($request->hasFile('file_icon_kategori')) {
            $filePath = $request->file('file_icon_kategori')->store('images/category', 'public');
            $validatedData['file_icon_kategori'] = $filePath;
            if (!empty($category->category_file_path) && $category->category_file_path != 'images/category/default.png') {
                Storage::disk('public')->delete($category->category_file_path);
            }
            $categoryFiles = CategoryFile::find($category->category_file_id);
            if (!$categoryFiles) {
                $categoryFiles = new CategoryFile;
            }
            $categoryFiles->file_name = $filePath;
            $categoryFiles->save();
            $category->category_file_id = $categoryFiles->id;
            $category->category_file_path = $filePath;
        }
        $category->nama_kategori = $request->tb_nama_kategori;
        $category->deskripsi_kategori = $request->tb_desk_kategori;
        $category->external_kategori_id = $request->tb_external_id;
        $category->save();
        return redirect()->route('category.index')->with('message', 'Kategori berhasil diperbaharui');
    }

    public function delete($id)
    {
        Produk::where('kategori_id', $id)
            ->update(['kategori_id' => 1]);
        $category = Kategori::findOrFail($id);
        if (!empty($category->category_file_path) && Storage::disk('public')->exists($category->category_file_path) && $category->category_file_path != 'images/category/default.png') {
            // Delete the file
            Storage::disk('public')->delete($category->category_file_path);
        }
        $category->delete();
        // return response()->json([
        //     'message' => "{$category} berhasil dihapus",
        // ], '200');

        return redirect()->route('category.index')->with('message', 'Data Kategori Berhasil Dihapus!');
    }
}
