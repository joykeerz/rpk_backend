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

    public function index()
    {
        $categories = Kategori::all();
        return response()->json([
            'data' => $categories,
        ],'200');
    }

    public function store(){

    }

    public function show($id){

    }

public function update(Request $request ,$id){

    }

    public function delete($id){

    }
}
