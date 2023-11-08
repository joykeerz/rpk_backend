<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{

    public function index()
    {
        $branch = DB::table('branches')
        ->join('companies', 'companies.id', '=', 'branches.company_id')
        ->get();
        // return response()->json([
        //     'message' => 'Branch berhasil ditampilkan',
        //     'data' => $branch
        // ], 200);


        return view('branch.index', compact('branch'));
    }

    public function manage()
    {
        $company = Company::all();
        return response()->json([
            'message' => 'Company berhasil ditampilkan',
            'data' => $company
        ], 200);
        // return view('branch.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $branch = new Branch;
        $branch->company_id = $request->cb_company_id;
        $branch->nama_branch = $request->tb_nama_branch;
        $branch->no_telp_branch = $request->tb_no_telp_branch;
        $branch->alamat_branch = $request->tb_alamat_branch;
        $branch->save();

        // return response()->json([
        //     'message' => 'Branch berhasil ditambahkan',
        //     'data' => $branch
        // ], 200);

        return redirect()->route('branch.index')->with('success', 'Branch berhasil ditambahkan');
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
        ->first();

        // return response()->json([
        //     'message' => 'Branch berhasil ditampilkan',
        //     'data' => $branch
        // ], 200);
        return view('branch.show', compact('branch'));
    }

    public function update(Request $request,$id){
        $branch = Branch::find($id);
        $branch->company_id = $request->cb_company_id;
        $branch->nama_branch = $request->tb_nama_branch;
        $branch->no_telp_branch = $request->tb_no_telp_branch;
        $branch->alamat_branch = $request->tb_alamat_branch;
        $branch->save();

        return response()->json([
            'message' => 'Branch berhasil diupdate',
            'data' => $branch
        ], 200);
        // return redirect()->route('branch.index')->with('success', 'Branch berhasil diupdate');
    }

    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        return response()->json([
            'message' => 'Branch berhasil dihapus',
            'data' => $branch
        ], 200);
        // return redirect()->route('branch.index')->with('success', 'Branch berhasil dihapus');
    }

}
