<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Gudang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $companies = DB::table('companies')
            ->join('users', 'users.id', '=', 'companies.user_id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->select('companies.*', 'alamat.*', 'users.*', 'companies.id as cid', 'alamat.id as aid', 'users.id as uid')
            ->paginate(15);

        return view('company.index', ['companies' => $companies]);
    }

    public function create()
    {
        $usersData = User::all();

        return view('company.create', ['usersData' => $usersData]);
        ///user data untuk dropdown pilih user(Contact Person Cabang)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tb_kode_company' => 'required|unique:companies,kode_company',
            'tb_nama_company' => 'required',
            'tb_partner_company' => 'required',
            'tb_tagline_company' => 'required',
            'tb_jalan' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kodepos' => 'required',
            'tb_user_id' => 'required|unique:companies,user_id'
        ], [
            'tb_kode_company.required' => 'Kode Company harus diisi',
            'tb_kode_company.unique' => 'Kode Company sudah terdaftar',
            'tb_nama_company.required' => 'Nama Company harus diisi',
            'tb_partner_company.required' => 'Partner Company harus diisi',
            'tb_tagline_company.required' => 'Tagline Company harus diisi',
            'tb_jalan.required' => 'Jalan harus diisi',
            'tb_prov.required' => 'Provinsi harus diisi',
            'tb_kota.required' => 'Kota harus diisi',
            'tb_kecamatan.required' => 'Kecamatan harus diisi',
            'tb_kodepos.required' => 'Kode Pos harus diisi',
            'tb_user_id.required' => 'User harus diisi',
            'tb_user_id.unique' => 'User sudah terdaftar'
        ]);

        $alamat = new Alamat;
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_ext;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_prov;
        $alamat->kota_kabupaten = $request->tb_kota;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        $company = new Company;
        $company->alamat_id = $alamat->id;
        $company->user_id = $request->tb_user_id;
        $company->kode_company = $request->tb_kode_company;
        $company->nama_company = $request->tb_nama_company;
        $company->partner_company = $request->tb_partner_company;
        $company->tagline_company = $request->tb_tagline_company;
        $company->external_company_id = $request->tb_external_id;
        $company->save();

        return redirect()->route('company.index')->with('message', 'Company berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = DB::table('companies')
            ->join('users', 'companies.user_id', '=', 'users.id')
            ->join('alamat', 'companies.alamat_id', '=', 'alamat.id')
            ->select('companies.*', 'alamat.*', 'users.*', 'companies.id as cid', 'alamat.id as aid', 'users.id as uid')
            ->where('companies.id', '=', $id)
            ->first();

        $usersData = User::all();

        if ($company == null) {
            return response()->json([
                'error' => 'resource not found'
            ], '404');
        }

        return view('company.show', ['company' => $company, 'usersData' => $usersData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // dd($request->tb_tagline_company);
        // $validated = $request->validate([
        //     'tb_kode_company' => 'required|unique:companies,kode_company',
        // ],[
        //     'tb_kode_company.required' => 'Kode Company harus diisi',
        //     'tb_kode_company.unique' => 'Kode Company sudah terdaftar',
        // ]);

        $company = Company::findOrFail($id);
        $company->user_id = $request->tb_user_id;
        $company->kode_company = $request->tb_kode_company;
        $company->nama_company = $request->tb_nama_company;
        $company->partner_company = $request->tb_partner_company;
        $company->tagline_company = $request->tb_tagline_company;
        $company->external_company_id = $request->tb_external_id;
        $company->save();

        $alamat = Alamat::findOrFail($company->alamat_id);
        $alamat->jalan = $request->tb_jalan;
        $alamat->jalan_ext = $request->tb_jalan_ext;
        $alamat->blok = $request->tb_blok;
        $alamat->rt = $request->tb_rt;
        $alamat->rw = $request->tb_rw;
        $alamat->provinsi = $request->tb_prov;
        $alamat->kota_kabupaten = $request->tb_kota;
        $alamat->kecamatan = $request->tb_kecamatan;
        $alamat->kelurahan = $request->tb_kelurahan;
        $alamat->negara = 'indonesia';
        $alamat->kode_pos = $request->tb_kodepos;
        $alamat->save();

        return redirect()->route('company.index')->with('message', 'Company berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Branch::where('company_id', $id)
            ->update(['company_id' => 1]);


        Gudang::where('company_id', $id)
            ->update(['company_id' => 1]);

        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')->with('message', 'Company berhasil dihapus');
    }
}
