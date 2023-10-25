<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $categories = Kategori::all();
    }
}
