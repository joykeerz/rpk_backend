@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<header class="bg-gray-200 p-4">
    <h2>
        {{ $product->nama_produk }} (Gudang : {{ $product->nama_gudang}})
    </h2>
</header>

<form action="" method="post">
    @csrf
    <div class="p-4 flex flex-col">
        <div>
            <div id="namaProduk" class="mb-3">
                <label for="" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_nama_produk" id="tb_nama_produk" placeholder="" value="{{ $product->nama_produk }}">
            </div>
            <div id="kodeProduk" class="mb-3">
                <label for="" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_kode_produk" id="tb_kode_produk" placeholder="" value="{{ $product->kode_produk }}">
            </div>
            <div id="deskripsiProduk" class="mb-3">
                <label for="deskripsiProduk" class="block text-sm font-medium text-gray-700">Deskripsi
                    Produk</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_desk_produk" id="tb_desk_produk" placeholder="" value="{{ $product->desk_produk }}">
                <small id="helpId" class="text-gray-500 text-xs"></small>
            </div>

            <div id="kategori" class="mb-3">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="cb_kategori" name="cb_kategori"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                    @forelse ($kategoriData as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $product->kategori_id) selected @endif>{{ $item->nama_kategori }}</option>
                    @empty
                        <option value="">Tidak ada data</option>
                    @endforelse
                </select>
                <small id="helpId" class="text-gray-500 text-xs"></small>
            </div>

            <div id="stok" class="mb-3">
                <label for="" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_jumlah_stok" value="{{ $product->jumlah_stok }}" placeholder="">
                <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
            </div>

            <div id="harga" class="mb-3">
                <label for="" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_harga_produk" value="{{ $product->harga_produk }}" placeholder="">
            </div>


</form>


@endsection
