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
            {{ $product->nama_produk }}
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </h2>
    </header>

    <form action="{{ route('product.update', ['id' => $product->id]) }}" method="post">
        @csrf
        <div class="p-4 flex flex-col">
            <div>
                <div id="namaProduk" class="mb-3">
                    <label for="" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                        name="tb_nama_produk" id="tb_nama_produk" placeholder="" value="{{ $product->nama_produk }}">
                    @error('tb_nama_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div id="kodeProduk" class="mb-3">
                    <label for="" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                        name="tb_kode_produk" id="tb_kode_produk" placeholder="" value="{{ $product->kode_produk }}">
                    @error('tb_kode_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div id="deskripsiProduk" class="mb-3">
                    <label for="deskripsiProduk" class="block text-sm font-medium text-gray-700">Deskripsi
                        Produk</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                        name="tb_desk_produk" id="tb_desk_produk" placeholder="" value="{{ $product->desk_produk }}">
                    @error('tb_desk_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div id="kategori" class="mb-3">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="cb_kategori" name="cb_kategori"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                        @forelse ($kategoriData as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $product->kategori_id) selected @endif>
                                {{ $item->nama_kategori }}</option>
                        @empty
                            <option value="">Tidak ada data</option>
                        @endforelse
                    </select>
                    @error('cb_kategori')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div id="harga" class="mb-3">
                    <label for="" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                        name="tb_harga_produk" value="{{ $product->harga_produk }}" placeholder="">

                    @error('tb_harga_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="buttonContainer flex justify-center p-4">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
    </form>
@endsection
