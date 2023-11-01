@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<hr>
    <div class="container mx-auto">
        <div class="border rounded">
            <div class="bg-gray-200 p-4">
                New Product
            </div>
            <div class="p-4 ">
                <div>
                    <div id="namaProduk" class="mb-3">
                      <label for="" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                      <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1" name="tb_product_name" id="tb_product_name" placeholder="">
                      <small id="helpId" class="text-gray-500 text-xs"></small>
                    </div>
                    <div id="tipe" class="mb-3">
                      <label for="" class="block text-sm font-medium text-gray-700">Tipe</label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                            <option selected>Open this select menu</option>
                        </select>
                      <small id="helpId" class="text-gray-500 text-xs"></small>
                    </div>
                    <div id="stok" mb-3">
                      <label for="" class="block text-sm font-medium text-gray-700">Stok</label>
                      <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_product_name" id="tb_product_name" value="0" placeholder="">
                      <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                    </div>
                    <div id="gudang" class="mb-3">
                      <label for="" class="block text-sm font-medium text-gray-700">Gudang</label>
                      <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_product_name" id="tb_product_name" value="0" placeholder="">
                    </div>
                    <div id="harga" class="mb-3">
                      <label for="" class="block text-sm font-medium text-gray-700">Harga</label>
                      <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_product_name" id="tb_product_name" value="0" placeholder="">
                      <small id="helpId" class="text-gray-500 text-xs"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

