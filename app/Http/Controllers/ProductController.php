<?php

namespace App\Http\Controllers;

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
        return view('product.index', ['productsData' => $Products]);
    }

    function store(Request $request)
    {
        $data = $request->validate([
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
            'harga_produk' => 'required',
            'kategori_id' => 'required',
            'stok_produk' => 'required',
        ]);

        Produk::create($data);

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
