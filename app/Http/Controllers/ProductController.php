<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $Products = Produk::all();
        $category = Kategori::all();
        return view('product.index', ['productsData' => $Products]);
    }

    function store(Request $request)
    {
        $product = new Produk;

    }

    function edit($id)
    {
    }

    function update(Request $request, $id)
    {
    }

    function delete($id)
    {
    }
}
