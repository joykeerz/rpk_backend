<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class BeritaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $berita = Berita::all();
        return view('berita.index', compact('berita'));
    }

    public function show($id){
        $berita = DB::table('berita')
            ->join('users', 'berita.user_id', '=', 'users.id')
            ->select('berita.*', 'users.name', 'users.id as uid')
            ->where('berita.id', $id)
        ->first();

        return view('berita.show', compact('berita'));
    }

    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request){
        $request->validate([
            'judul_berita' => 'required',
            'deskripsi_berita' => 'required',
            'gambar_berita' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'penulis_berita' => 'required',
            'kategori_berita' => 'required',
        ],[
            'judul_berita' => 'Judul berita harus diisi',
            'deskripsi_berita' => 'Deskripsi berita harus diisi',
            'penulis_berita' => 'Penulis berita harus diisi',
            'kategori_berita' => 'Kategori berita harus diisi',
            'gambar_berita.required' => 'Gambar berita harus diisi',
            'gambar_berita.image' => 'Gambar berita harus berupa gambar',
            'gambar_berita.mimes' => 'Gambar berita harus berformat jpeg, png, jpg',
            'gambar_berita.max' => 'Ukuran gambar berita maksimal 2 MB',
        ]);

        $berita = new Berita;
        $berita->judul_berita = $request->judul_berita;
        $berita->deskripsi_berita = $request->deskripsi_berita;
        if ($request->hasFile('gambar_berita')) {
            $filePath = $request->file('gambar_berita')->store('images/berita', 'public');
            $validatedData['gambar_berita'] = $filePath;
            $berita->gambar_berita = $filePath;
        }
        $berita->slug_berita = Str::slug($request->judul_berita);
        $berita->penulis_berita = $request->penulis_berita;
        $berita->kategori_berita = $request->kategori_berita;
        $berita->user_id = auth()->user()->id;
        $berita->external_berita_id = $request->external_id;
        $berita->save();

        return redirect()->route('berita.index')->with('message', 'Berita berhasil ditambahkan');
    }

    public function update(Request $request){
        $request->validate([
            'judul_berita' => 'required',
            'deskripsi_berita' => 'required',
            'gambar_berita' => 'image|mimes:jpeg,png,jpg|max:2048',
            'penulis_berita' => 'required',
            'kategori_berita' => 'required',
        ],[
            'judul_berita' => 'Judul berita harus diisi',
            'deskripsi_berita' => 'Deskripsi berita harus diisi',
            'penulis_berita' => 'Penulis berita harus diisi',
            'kategori_berita' => 'Kategori berita harus diisi',
            'gambar_berita.image' => 'Gambar berita harus berupa gambar',
            'gambar_berita.mimes' => 'Gambar berita harus berformat jpeg, png, jpg',
            'gambar_berita.max' => 'Ukuran gambar berita maksimal 2 MB',
        ]);

        $berita = Berita::find($request->id);
        $berita->judul_berita = $request->judul_berita;
        $berita->deskripsi_berita = $request->deskripsi_berita;
        if ($request->hasFile('gambar_berita')) {
            $filePath = $request->file('gambar_berita')->store('images/berita', 'public');
            $validatedData['gambar_berita'] = $filePath;
            if (!empty($berita->gambar_berita)) {
                Storage::disk('public')->delete($berita->gambar_berita);
            }
            $berita->gambar_berita = $filePath;
        }
        $berita->slug_berita = Str::slug($request->judul_berita);
        $berita->penulis_berita = $request->penulis_berita;
        $berita->kategori_berita = $request->kategori_berita;
        $berita->user_id = auth()->user()->id;
        $berita->save();

        return redirect()->route('berita.index')->with('message', 'Berita berhasil diubah');
    }

    public function delete($id){
        $berita = Berita::find($id);
        if (!empty($berita->gambar_berita)) {
            Storage::disk('public')->delete($berita->gambar_berita);
        }
        $berita->delete();

        return redirect()->route('berita.index')->with('message', 'Berita berhasil dihapus');
    }
}
