<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $branch = DB::table('branches')
            ->join('companies', 'companies.id', '=', 'branches.company_id')
            ->select('branches.*', 'companies.nama_company', 'branches.id as bid', 'companies.id as cid')
            ->when($search, function ($query, $search) {
                $query->where('nama_branch', 'ilike', '%' . $search . '%')
                    ->orWhere('no_telp_branch', 'ilike', '%' . $search . '%')
                    ->orWhere('alamat_branch', 'ilike', '%' . $search . '%')
                    ->orWhere('nama_company', 'ilike', '%' . $search . '%');
            })
            ->paginate(15);
        return view('branch.index', compact('branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cb_company_id' => 'required',
            'tb_nama_branch' => 'required',
            'tb_no_telp_branch' => 'required|numeric',
            'tb_alamat_branch' => 'required',
        ], [
            'cb_company_id.required' => 'Nama Company harus diisi',
            'tb_nama_branch.required' => 'Nama Branch harus diisi',
            'tb_no_telp_branch.required' => 'No Telp harus diisi',
            'tb_alamat_branch.required' => 'Alamat harus diisi',
            'tb_no_telp_branch.numeric' => 'No Telp harus berupa angka',
        ]);

        $branch = new Branch;
        $branch->id = Branch::count() + 1;
        $branch->company_id = $request->cb_company_id;
        $branch->nama_branch = $request->tb_nama_branch;
        $branch->no_telp_branch = $request->tb_no_telp_branch;
        $branch->alamat_branch = $request->tb_alamat_branch;
        $branch->external_branch_id = $request->tb_id_external;
        $branch->save();

        return redirect()->route('branch.index')->with('message', 'Branch berhasil ditambahkan');
    }

    public function create()
    {
        $usersData = User::all();
        $companyData = Company::all();
        return view('branch.create', ['usersData' => $usersData, 'companyData' => $companyData]);
    }

    public function show($id)
    {
        $branch = DB::table('branches')
            ->join('companies', 'companies.id', '=', 'branches.company_id')
            ->where('branches.id', '=', $id)
            ->select('branches.*', 'companies.*', 'branches.id as bid', 'companies.id as cid')
            ->first();
        $companyData = Company::all();

        return view('branch.show', ['branch' => $branch, 'companyData' => $companyData]);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);
        $branch->company_id = $request->cb_company_id;
        $branch->nama_branch = $request->tb_nama_branch;
        $branch->no_telp_branch = $request->tb_no_telp_branch;
        $branch->alamat_branch = $request->tb_alamat_branch;
        $branch->external_branch_id = $request->tb_id_external;
        $branch->save();

        return redirect()->route('branch.index')->with('message', 'Branch berhasil diupdate');
    }

    public function delete($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        return redirect()->route('branch.index')->with('message', 'Branch berhasil dihapus');
    }
}
