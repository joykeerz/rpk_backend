<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Gudang;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('companies.nama_company','gudang.*', 'alamat.*', 'gudang.id as gid', 'alamat.id as aid')
            ->when($search, function ($query, $search) {
                $query->where('nama_gudang', 'ilike', '%' . $search . '%')
                    ->orWhere('nama_gudang_erp', 'ilike', '%' . $search . '%');
            })
            ->paginate(15);

        $res =  response()->json([
            'data' => $gudang
        ], 200);

        // foreach ($products as $key => $value) {
        //     echo "$key:$value->nama_produk, ";
        // }
        //return $res;
        return view('gudang.index', ['gudangData' => $gudang]);
    }

    public function create()
    {
        $usersData = User::where('role_id', 4)->get();
        $companyData = Company::all();
        $branchData = Branch::all();

        return view('gudang.create', ['usersData' => $usersData, 'companyData' => $companyData, 'branchData' => $branchData]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tb_nama_gudang' => 'required',
            'tb_no_telp' => 'required',
            'tb_jalan' => 'required',
            'tb_prov' => 'required',
            'tb_kota' => 'required',
            'tb_kecamatan' => 'required',
            'tb_kodepos' => 'required',
            'cb_company_id' => 'required',
            'cb_user_id' => 'required',
        ], [
            'tb_nama_gudang.required' => 'Nama Gudang tidak boleh kosong!',
            'tb_no_telp.required' => 'No Telepon tidak boleh kosong!',
            'tb_jalan.required' => 'Jalan tidak boleh kosong!',
            'tb_prov.required' => 'Provinsi tidak boleh kosong!',
            'tb_kota.required' => 'Kota tidak boleh kosong!',
            'tb_kecamatan.required' => 'Kecamatan tidak boleh kosong!',
            'tb_kodepos.required' => 'Kode Pos tidak boleh kosong!',
            'cb_company_id.required' => 'Company tidak boleh kosong!',
            'cb_user_id.required' => 'User tidak boleh kosong!',
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

        $gudang = new Gudang;
        $gudang->id = Gudang::max('id') + 1;
        $gudang->alamat_id = $alamat->id;
        $gudang->company_id = $request->cb_company_id;
        $gudang->branch_id = $request->cb_branch_id;
        $gudang->user_id = $request->cb_user_id;
        $gudang->nama_gudang = $request->tb_nama_gudang;
        $gudang->nama_gudang_erp = $request->tb_nama_gudang_erp;
        $gudang->no_telp = $request->tb_no_telp;
        $gudang->external_gudang_id = $request->tb_external_id;
        $gudang->save();

        return redirect()->route('gudang.index')->with('message', 'Data Gudang Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        $usersData = User::where('role_id', 4)->get();
        $companyData = Company::all();
        $branchData = Branch::all();
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'companies.id as cid')
            ->where('gudang.id', '=', $id)
            ->first();
        if (!$gudang) {
            return redirect()->route('gudang.index')->with('message', 'Data Gudang Tidak Ditemukan atau belum lengkap. harap hubungi admin');
        }
        $data = [
            'gudang' => $gudang,
            'usersData' => $usersData,
            'companyData' => $companyData,
            'branchData' => $branchData,
        ];

        $res = response()->json([
            'data' => $gudang,
        ], 200);

        return view('gudang.show', ['data' => $data,]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->input());
        $gudang = Gudang::findOrFail($id);
        $gudang->company_id = $request->cb_company_id;
        $gudang->alamat_id = $gudang->alamat_id;
        $gudang->user_id = $request->cb_user_id;
        $gudang->branch_id = $request->cb_branch_id;
        $gudang->nama_gudang = $request->tb_nama_gudang;
        $gudang->nama_gudang_erp = $request->tb_nama_gudang_erp;
        $gudang->no_telp = $request->tb_no_telp;
        $gudang->external_gudang_id = $request->tb_external_id;
        $gudang->save();

        $alamat = Alamat::findOrFail($gudang->alamat_id);
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

        return redirect()->route('gudang.index')->with('message', 'Data Gudang Berhasil Diupdate!');
    }

    public function delete($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();
        $alamat = Alamat::where('id', $gudang->alamat_id);
        $alamat->delete();
        $stok = Stok::where('gudang_id', $id);
        $stok->delete();

        return redirect()->route('gudang.index')->with('message', 'Data Gudang Berhasil Dihapus!');
    }

    public function searchGudang(Request $request)
    {
        $gudang = DB::table('gudang')
            ->join('alamat', 'gudang.alamat_id', '=', 'alamat.id')
            ->join('companies', 'gudang.company_id', '=', 'companies.id')
            ->select('gudang.*', 'alamat.*', 'companies.*', 'gudang.id as gid', 'alamat.id as aid', 'companies.id as cid')
            ->where('title', 'LIKE', '%' . $request->search . "%")->get();
        if ($gudang) {
            return response()->json($gudang);
        }
    }
}
