<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $banners = DB::table('banners')->when($search, function ($query, $search) {
            $query->where('judul_banner', 'ilike', '%' . $search . '%');
        })->paginate(15);
        return view('banner.index', compact('banners'));
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_banner' => 'required',
            'deskripsi_banner' => 'required',
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'judul_banner.required' => 'Judul banner harus diisi',
            'deskripsi_banner.required' => 'Deskripsi banner harus diisi',
            'gambar_banner.required' => 'Gambar banner harus diisi',
            'gambar_banner.image' => 'Gambar banner harus berupa gambar',
            'gambar_banner.mimes' => 'Gambar banner harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'gambar_banner.max' => 'Gambar banner maksimal 2MB',
        ]);

        $banner = new Banner;
        $banner->judul_banner = $request->judul_banner;
        $banner->deskripsi_banner = $request->deskripsi_banner;
        if ($request->hasFile('gambar_banner')) {
            $filePath = $request->file('gambar_banner')->store('images/banner', 'public');
            $validatedData['gambar_banner'] = $filePath;
            $banner->gambar_banner = $filePath;
        }
        $banner->save();

        return redirect()->route('banner.index')->with('message', 'Banner berhasil ditambahkan');
    }

    public function show($id)
    {
        $banner = Banner::find($id);
        return view('banner.show', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_banner' => 'required',
            'deskripsi_banner' => 'required',
            'gambar_banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'judul_banner.required' => 'Judul banner harus diisi',
            'deskripsi_banner.required' => 'Deskripsi banner harus diisi',
            'gambar_banner.image' => 'Gambar banner harus berupa gambar',
            'gambar_banner.mimes' => 'Gambar banner harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'gambar_banner.max' => 'Gambar banner maksimal 2MB',
        ]);
        $banner = Banner::find($id);
        $banner->judul_banner = $request->judul_banner;
        $banner->deskripsi_banner = $request->deskripsi_banner;
        if ($request->hasFile('gambar_banner')) {
            $filePath = $request->file('gambar_banner')->store('images/banner', 'public');
            $validatedData['gambar_banner'] = $filePath;
            if (!empty($banner->gambar_banner)) {
                Storage::disk('public')->delete($banner->gambar_banner);
            }
            $banner->gambar_banner = $filePath;
        }
        $banner->save();

        return redirect()->route('banner.index')->with('message', 'Banner berhasil diubah');
    }

    public function delete($id){
        $banner = Banner::find($id);
        if (!empty($banner->gambar_banner)) {
            Storage::disk('public')->delete($banner->gambar_banner);
        }
        $banner->delete();
        return redirect()->route('banner.index')->with('message', 'Banner berhasil dihapus');
    }
}
