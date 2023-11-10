@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    @if (session('message'))
        <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" id="alertMessage">
            {{ session('message') }}
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
    @endif
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
                <select class="border rounded-md py-2 px-3 w-full" name="cb_produk" id="cb_produk">
                    <option selected value="{{ $stock->sid }}">{{ $stock->nama_produk }}</option>
                </select>
                <label class="block text-sm font-medium text-gray-700" for="tb_jumlah_produk">Jumlah Produk:</label>
                <input value="{{ $stock->jumlah_stok }}" id="tb_jumlah_produk" type="number"
                    class="border rounded-md py-2 px-3 w-full" name="tb_jumlah_produk" placeholder="">

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
