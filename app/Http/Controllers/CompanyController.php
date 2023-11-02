<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companies = DB::table('companies')
            ->join('users', 'users.id', '=', 'companies.user_id')
            ->join('alamat', 'alamat.id', '=', 'companies.alamat_id')
            ->get();

        return response()->json([
            'data' => $companies,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->alamat_id = $request->tb_alamat_id;
        $company->user_id = $request->tb_user_id;
        $company->kode_company = $request->tb_kode_company;
        $company->nama_company = $request->tb_nama_company;
        $company->partner_company = $request->tb_partner_company;
        $company->tagline_company = $request->tb_tagline_company;
        $company->save();

        return response()->json([
            'data' => $company,
        ], 200);
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

        if ($company == null) {
            return response()->json([
                'error' => 'resource not found'
            ], '404');
        }

        $res =  response()->json([
            'data' => $company,
        ], 200);
        return $res;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $company = Company::findOrFail($id);
        $company->alamat_id = $request->tb_alamat_id;
        $company->user_id = $request->tb_user_id;
        $company->kode_company = $request->tb_kode_company;
        $company->nama_company = $request->tb_nama_company;
        $company->partner_company = $request->tb_partner_company;
        $company->tagline_company = $request->tb_tagline_company;
        $company->save();

        $res =  response()->json([
            'data' => $company,
        ], 200);
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Branch::where('company_id', $id)
            ->update(['company_id' => 1]);


        Gudang::where('company_id', $id)
        ->update(['company_id' => 1]);

        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json([
            'message' => "{$company} berhasil dihapus",
        ], '200');
    }
}
