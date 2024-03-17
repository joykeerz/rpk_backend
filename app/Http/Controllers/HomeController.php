<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stockCountByMonth = DB::table('stok')
            ->count();

        $transaksiCountByMonth  = DB::table('transaksi')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->count();

        $totalCustomer = DB::table('biodata')->count();

        return view('home', [
            'stockCountByMonth' => $stockCountByMonth,
            'transaksiCountByMonth' => $transaksiCountByMonth,
            'totalCustomer' => $totalCustomer,
        ]);
    }
}
