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

    public function show($id)
    {
        // Fetch the product with the given $id from the database
        $product = Produk::find($id);
        echo $product;

        // Check if the product exists
        if ($product == null) {
            // Return a 404 response if the product doesn't exist
            echo "Product not found";
        }

        return view('products.show', ['product' => $product]);
    }

    function index()
    {
        $Products = Produk::all();
        $category = Kategori::all();
        return view('product.index', ['productsData' => $Products]);
    }

    function manage ()
    {
        $Products = Produk::all();
        $category = Kategori::all();
        return view('product.manage', ['productsData' => $Products]);
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
