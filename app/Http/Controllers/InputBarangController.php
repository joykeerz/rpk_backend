<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class InputBarangController extends Controller
{


    public function index(){
        return view('inputBarang');
    }
}
