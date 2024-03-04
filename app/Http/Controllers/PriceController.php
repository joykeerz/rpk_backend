<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $currentEntity = DB::table('companies')
            ->join('branches', 'branches.company_id', '=', 'companies.id')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->select('companies.nama_company', 'branches.nama_branch', 'branches.id as bid', 'companies.id as cid')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

        if (empty($currentEntity)) {
            return redirect()->route('home')->with('error', 'Anda belum terdaftar di entitas/company manapun, harap hubungi admin');
        }

        $prices = DB::table('prices')
            ->join('produk', 'produk.id', '=', 'prices.produk_id')
            ->select('prices.*', 'produk.nama_produk', 'produk.kode_produk')
            ->where('prices.company_id', '=', Auth::user()->company_id)
            ->when($search, function ($query, $search) {
                $query->where('prices.kode_produk', 'ilike', '%' . $search . '%')
                    ->orWhere('prices.nama_produk', 'ilike', '%' . $search . '%');
            })
            // ->orderBy('prices.created_at', 'desc')
            ->distinct('prices.produk_id') // ini datanya jadi lebih sedikit. kalo ga dipake bakal ada kode produk duplikat, tapi memang dari import erp banyak data duplikat
            ->get();
        // dd($prices);

        $stocks = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.id')
            ->join('gudang', 'stok.gudang_id', '=', 'gudang.id')
            ->where('gudang.company_id', '=', $currentEntity->cid)
            ->select('stok.id', 'produk.nama_produk', 'produk.kode_produk', 'produk.id as produk_id')
            ->get();

        return view('price.index', ['prices' => $prices, 'currentEntity' => $currentEntity, 'stocks' => $stocks]);
    }

    public function store(Request $request)
    {
        dd(Auth::user()->company_id);
        $request->validate([
            'tb_price' => 'required',
        ], [
            'tb_price.required' => 'Harga harus diisi',
        ]);

        $checkProduct = Price::where('company_id', '=', Auth::user()->company_id)->where('produk_id', '=', $request->cb_produk)->first();
        if ($checkProduct) {
            return redirect()->back()->with('error', 'Produk sudah memiliki harga');
        }

        DB::table('prices')->insert([
            'id' => Price::count() + 1,
            'price_value' => $request->tb_price,
            'produk_id' => $request->cb_produk,
            'company_id' => Auth::user()->company_id,
        ]);

        return redirect()->back()->with('message', 'price created successfully.');
    }

    public function ajaxEdit(Request $request, $id)
    {
        $price = Price::find($id);

        if (!$price) {
            return response()->json(['error' => 'Price not found'], 404);
        }

        // Validate and update the fields as needed
        $request->validate([
            'price_value' => 'required|numeric',
        ]);

        $price->price_value = $request->price_value;
        $price->save();

        return response()->json(['message' => 'Price updated successfully']);
    }
}
