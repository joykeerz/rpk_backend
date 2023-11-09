<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customer = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
            ->where('users.role_id', '=', 5)
            ->orderby('biodata.created_at', 'desc')
            ->get();

        return view('customer.index', ['customer' => $customer]);
    }

    public function show($id)
    {
        $customer = DB::table('biodata')
            ->join('users', 'users.id', '=', 'biodata.user_id')
            ->join('alamat', 'alamat.id', '=', 'biodata.alamat_id')
            ->select('users.*', 'biodata.*', 'alamat.*', 'biodata.id as bid', 'users.id as uid', 'alamat.id as aid', 'biodata.created_at as cat')
            ->where('biodata.id', '=', $id)
            ->first();

        if (empty($customer)) {
            abort(404);
        }

        return view('customer.show', ['customer' => $customer]);
    }

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'tb_kode_customer' => 'required',
            'tb_nama_rpk' => 'required',
            'tb_no_ktp' => 'required',
            'tb_jalan' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_provinsi' => 'required',
            'tb_kota_kabupaten' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_kode_pos' => 'required',
        ]);

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_extra = $request->tb_jalan_extra;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_provinsi;
        $alamat->kota_kabupaten = $request->tb_kota_kabupaten;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kode_pos;
        $alamat->save();

        $customer = new Biodata;
        $customer->kode_customer = $request->tb_kode_customer;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_no_ktp;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tb_kode_customer' => 'required',
            'tb_nama_rpk' => 'required',
            'tb_no_ktp' => 'required',
            'tb_jalan' => 'required',
            'tb_blok' => 'required',
            'tb_rt' => 'required',
            'tb_rw' => 'required',
            'tb_provinsi' => 'required',
            'tb_kota_kabupaten' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kelurahan' => 'required',
            'tb_kode_pos' => 'required',
        ]);

        $customer = Biodata::findOrfail($id);
        $customer->kode_customer = $request->tb_kode_customer;
        $customer->nama_rpk = $request->tb_nama_rpk;
        $customer->no_ktp = $request->tb_no_ktp;
        $customer->save();

        $alamat = Alamat::where('id', '=', $customer->alamat_id)->first();
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_extra = $request->tb_jalan_extra;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_provinsi;
        $alamat->kota_kabupaten = $request->tb_kota_kabupaten;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kode_pos;
        $alamat->save();

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil diubah');
    }

    public function delete($id)
    {
        $customer = Biodata::findOrfail($id);
        $alamat = Alamat::where('id', '=', $customer->alamat_id)->first();
        $customer->delete();
        $alamat->delete();

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil dihapus');
    }
}
