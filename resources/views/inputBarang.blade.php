@extends('layouts.bar')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<main>
    <header class="text-center p-5">
        <h1 class="font-bold">Input Barang</h1>
    </header>
    <form action="product.store" method="get" class="p-5">
        @csrf
        <div class="w-full">
            <div class="inputGroup p-5 w-full ">
                <label for="namaProduk">Nama Produk</label> <br>
                <input type="text" id="namaProduk" class="namaProduk w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nama Produk">
            </div>
            <div class="flex justify-stretch gap-2">
                <div class="inputGroup p-5 flex-1 ">
                    <label for="kategori">Kategori</label> <br>
                    <select name="kategori" id="kategori" class="border w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option selected>Pilih Kategori</option>
                        <option value="beras">Beras</option>
                    </select>
                </div>
                <div class="jumlahProduk inputGroup p-5 flex-1">
                    <label for="jumlahProduk">Jumlah Produk</label> <br>
                    <input type="text" id="jumlahProduk" class="jumlahProduk w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="ex: 10 karung">
                </div>
                <div class="hargaProduk inputGroup p-5 flex-1">
                    <label for="hargaProduk">Harga Produk</label> <br>
                    <input type="text" id="hargaProduk" class="hargaProduk w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="tanpa menyertakan rupiah">
                </div>
            </div>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="m-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit
            </button>
        </div>

    </form>
</main>
@endsection
