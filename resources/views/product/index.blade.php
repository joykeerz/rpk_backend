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
            <form action="{{ Route('product.store') }}" method="post">
                @csrf
                <div class="p-4 flex flex-col">
                    <div>
                        <div id="namaProduk" class="mb-3">
                            <label for="" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                                name="tb_nama_produk" id="tb_nama_produk" placeholder="">
                        </div>
                        <div id="kodeProduk" class="mb-3">
                            <label for="" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                                name="tb_kode_produk" id="tb_kode_produk" placeholder="">
                        </div>
                        <div id="deskripsiProduk" class="mb-3">
                            <label for="deskripsiProduk" class="block text-sm font-medium text-gray-700">Deskripsi
                                Produk</label>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                name="tb_desk_produk" id="tb_desk_produk" placeholder="">
                            <small id="helpId" class="text-gray-500 text-xs"></small>
                        </div>

                        <div id="kategori" class="mb-3">
                            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select id="cb_kategori" name="cb_kategori"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                            @forelse ($kategoriData as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
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
                                name="tb_jumlah_stok" value="0" placeholder="">
                            <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                        </div>

                        <div id="diskonProduk" class="mb-3">
                            <label for="diskonProduk" class="block text-sm font-medium text-gray-700">Diskon Produk (dalam
                                persen)</label>
                            <input type="number" name="tb_diskon_produk"
                                id="tb_diskon_produk
                                class="mt-1 block w-full rounded-md
                                border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200
                                focus:ring-opacity-50 border border-gray-300 p-1" name="tb_diskon_produk"
                                id="tb_diskon_produk" value="0" placeholder="">
                        </div>

                        <div id="gudang" class="mb-3">
                            <label for="" class="block text-sm font-medium text-gray-700">Gudang</label>
                            <input
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                name="cb_gudang_id" id="cb_gudang_id" placeholder="">
                        </div>

                        <div id="hargaProduk" class="mb-3">
                            <label for="" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                name="tb_harga_produk" id="tb_harga_product" value="0" placeholder="">
                            <small id="helpId" class="text-gray-500 text-xs"></small>
                        </div>

                        <div id="satuanUnit" class="mb-3">
                            <label for="satuanUnit" class="block text-sm font-medium text-gray-700">Satuan Unit</label>
                            <select id="tb_satuan" name="tb_satuan"
                                class="mt-1
                                block border w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                <option disabled selected>Open this select menu</option>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Unit">Unit</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>

                    </div>
                    <button type="submit" class="px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
