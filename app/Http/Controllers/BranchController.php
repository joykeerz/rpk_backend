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

    public function index()
    {
        $branch = DB::table('branches')
            ->join('companies', 'companies.id', '=', 'branches.company_id')
            ->select('branches.*', 'companies.nama_company', 'branches.id as bid', 'companies.id as cid')
            ->paginate(15);
        return view('branch.index', compact('branch'));
    }

    public function store(Request $request)
    {
        $branch = new Branch;
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
            ->select('branches.*','companies.*','branches.id as bid', 'companies.id as cid')
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
