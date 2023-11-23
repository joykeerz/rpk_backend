@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    @include('layouts.alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <div class="title bg-gray-200 p-4">
        <h3 class="text-xl">Modify Product Stock</h3>
    </div>

    <div class="w-full md:w-1/2 border rounded-lg my-4 mx-auto">
        <form action="{{ route('stok.update', ['id' => $stock->sid]) }}" method="POST">
            @csrf
            <div class="inputKategori p-4">
                <label class="block text-sm font-medium text-gray-700" for="cb_produk">Pilih Produk:</label>
                <select disabled class="border rounded-md py-2 px-3 w-full" name="cb_produk" id="cb_produk">
                    <option selected value="{{ $stock->sid }}">{{ $stock->nama_produk }}</option>
                </select>
                <label class="block text-sm font-medium text-gray-700" for="tb_jumlah_produk">Jumlah Produk:</label>
                <input value="{{ $stock->jumlah_stok }}" id="tb_jumlah_produk" type="number"
                    class="border rounded-md py-2 px-3 w-full" name="tb_jumlah_produk" placeholder="">
                <label class="block text-sm font-medium text-gray-700" for="tb_harga_stok">Harga Stok:</label>
                <input value="{{ $stock->harga_stok }}" id="tb_harga_stok" type="number"
                    class="border rounded-md py-2 px-3 w-full" name="tb_harga_stok" placeholder="">

                <input type="hidden" name="tb_gudang_id" value="{{ $stock->gid }}">
                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-xs italic">{{ $error }}</p>
                @endforeach
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white py-1 px-4 rounded-md hover:bg-blue-600 m-auto my-2">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <hr>
@endsection
