<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\DaftarAlamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DaftarAlamatController extends Controller
{
    //
    function index($userID)
    {
        // $alamatList = DaftarAlamat::where('user_id', $userID)->simplePaginate(5);
        $alamatList = DB::table('daftar_alamat')
            ->join('alamat', 'alamat.id', 'daftar_alamat.alamat_id')
            ->simplePaginate(5);
        return view('customer.daftar-alamat', ['alamatList' => $alamatList, 'userID' => $userID]);
    }

    function show($alamatID)
    {
        $alamat = Alamat::find($alamatID);
        return view('customer.detail-alamat', ['alamat' => $alamat]);
    }

    function update(Request $request, $alamatID)
    {
        $request->validate([
            'tb_jalan' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_kodepos' => 'required',
        ], [
            'tb_jalan.required' => 'Jalan tidak boleh kosong',
            'tb_blok.required' => 'Blok tidak boleh kosong',
            'tb_rt.required' => 'RT tidak boleh kosong',
            'tb_rw.required' => 'RW tidak boleh kosong',
            'tb_prov.required' => 'Provinsi tidak boleh kosong',
            'tb_kota.required' => 'Kota/Kabupaten tidak boleh kosong',
            'tb_kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'tb_kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'tb_kodepos.required' => 'Kode pos tidak boleh kosong',
        ]);

        $alamat = Alamat::where('id', $alamatID)->update([
            'jalan' => $request->tb_jalan,
            'jalan_ext' => $request->tb_jalan_2,
            'blok' => $request->tb_blok,
            'rt' => $request->tb_rt,
            'rw' => $request->tb_rw,
            'provinsi' => $request->tb_prov,
            'kota_kabupaten' => $request->tb_kota,
            'kecamatan' => $request->tb_kecamatan,
            'kelurahan' => $request->tb_kelurahan,
            'negara' => 'Indonesia',
            'kode_pos' => $request->tb_kodepos,
        ]);

        return redirect()->back()->with('message', 'alamat berhasil diubah');
    }

    public function create($userID)
    {
        return view('customer.new-alamat', ['userID' => $userID]);
    }

    function insert(Request $request, $UserID)
    {
        $request->validate([
            'tb_jalan' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_kodepos' => 'required',
        ], [
            'tb_jalan.required' => 'Jalan tidak boleh kosong',
            'tb_blok.required' => 'Blok tidak boleh kosong',
            'tb_rt.required' => 'RT tidak boleh kosong',
            'tb_rw.required' => 'RW tidak boleh kosong',
            'tb_prov.required' => 'Provinsi tidak boleh kosong',
            'tb_kota.required' => 'Kota/Kabupaten tidak boleh kosong',
            'tb_kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'tb_kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'tb_kodepos.required' => 'Kode pos tidak boleh kosong',
        ]);

        $alamat = Alamat::create([
            'jalan' => $request->tb_jalan,
            'jalan_ext' => $request->tb_jalan_2,
            'blok' => $request->tb_blok,
            'rt' => $request->tb_rt,
            'rw' => $request->tb_rw,
            'provinsi' => $request->tb_prov,
            'kota_kabupaten' => $request->tb_kota,
            'kecamatan' => $request->tb_kecamatan,
            'kelurahan' => $request->tb_kelurahan,
            'negara' => 'Indonesia',
            'kode_pos' => $request->tb_kodepos,
        ]);

        $daftarAlamat = DaftarAlamat::create([
            'user_id' => $UserID,
            'alamat_id' => $alamat->id,
            'isActive' => false,
        ]);

        return redirect()->route('daftar-alamat.customer.index', ['id' => $UserID])->with('message', 'alamat berhasil ditambahkan');
    }

    public function delete($alamatID)
    {
        $alamat = Alamat::find($alamatID);
        $daftarAlamat = DaftarAlamat::where('alamat_id', $alamatID)->first();
        $checkAlamat = DaftarAlamat::where('user_id', $daftarAlamat->user_id)->get();
        if ($checkAlamat->count() <= 1) {
            return redirect()->back()->with('error', 'alamat hanya satu, tidak bisa dihapus');
        }
        if ($daftarAlamat->isActive == true) {
            return redirect()->back()->with('error', 'alamat aktif tidak bisa dihapus');
        }
        $alamat->delete();
        $daftarAlamat->delete();
        return redirect()->back()->with('message', 'alamat berhasil dihapus');
    }

    public function toggle($alamatID)
    {
        $daftarAlamat = DaftarAlamat::where('alamat_id', $alamatID)->first();
        $otherAlamat = DaftarAlamat::where('user_id', $daftarAlamat->user_id)->update(['isActive' => false]);
        $daftarAlamat->isActive = true;
        $daftarAlamat->save();
        $biodata = Biodata::where('user_id', $daftarAlamat->user_id)->first();
        $biodata->alamat_id = $alamatID;
        $biodata->save();
        return redirect()->back()->with('message', 'alamat diaktifkan');
    }
}
