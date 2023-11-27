@extends('layouts.bar')

@section('plugins')
@endsection

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
            <div class="formContainer m-3 border rounded p-3">
                <form enctype="multipart/form-data" action="{{ Route('product.store') }}" method="post">
                    @csrf
                    <div>
                        <div class="p-4 grid grid-cols-2 gap-1">
                            <div id="namaProduk" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                                    name="tb_nama_produk" id="tb_nama_produk" placeholder="">
                                @error('tb_nama_produk')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="kodeProduk" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Kode Produk</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                                    name="tb_kode_produk" id="tb_kode_produk" placeholder="">
                                @error('tb_kode_produk')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="deskripsiProduk" class="mb-3">
                                <label for="deskripsiProduk" class="block text-sm font-medium text-gray-700">Deskripsi
                                    Produk</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                    name="tb_desk_produk" id="tb_desk_produk" placeholder="">
                                @error('tb_desk_produk')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="kategori" class="mb-3">
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select id="cb_kategori" name="cb_kategori"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                    <option disabled selected>Open this select menu</option>
                                    @forelse ($kategoriData as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @empty
                                        <option value="">Tidak ada data</option>
                                    @endforelse
                                </select>
                                @error('cb_kategori')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="diskonProduk" class="mb-3">
                                <label for="diskonProduk" class="block text-sm font-medium text-gray-700">Diskon Produk
                                    (dalam
                                    persen)</label>
                                <input value="0" type="number" name="tb_diskon_produk" id="tb_diskon_produk"
                                    class="mt-1 block w-full
                                    rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                    name="tb_diskon_produk" id="tb_diskon_produk" placeholder="">
                                @error('tb_diskon_produk')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                                <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                            </div>

                            <div id="satuanUnit" class="mb-3">
                                <label for="satuanUnit" class="block text-sm font-medium text-gray-700">Satuan Unit</label>
                                <select id="tb_satuan" name="tb_satuan"
                                    class="
                                    block border w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                    <option disabled selected>Open this select menu</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Gram">Gram</option>
                                    <option value="Liter">Liter</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Box">Box</option>
                                </select>
                                @error('tb_satuan')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="externalIdProduk" class="mb-3">
                                <label for="externalIdProduk" class="block text-sm font-medium text-gray-700">ID
                                    Eksternal</label>
                                <input type="text" name="tb_external_id" id="tb_external_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                    name="tb_external_id" id="tb_external_id">
                                @error('tb_external_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                                <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                            </div>
                        </div>
                        <div id="imageProduk" class="mb-3">
                            <label for="imageProduk" class="block text-sm font-medium text-gray-700">Gambar
                                Produk</label>
                            <img id="preview_img" class="h-56 w-full object-cover">
                            <input onchange="loadFile(event)" value="0" type="file" name="file_image_produk"
                                id="file_image_produk"
                                class="mt-1 block w-full
                                rounded-md shadow-sm focus:border-indigo-300 focus:ring
                                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                name="file_image_produk" id="file_image_produk">
                            @error('file_image_produk')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                        </div>


                        <div class="buttonContainer flex justify-center">
                            <button type="submit"
                                class="px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200">
                                Submit
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>

    <style>
        input[type=text],
        select,
        textarea,
        input[type=number] {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 3px 6px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            margin: 0 3px;
            width: 100%;
        }
    </style>
@endsection

@section('script')
    <script>
        var loadFile = function(event) {

            var input = event.target;
            var file = input.files[0];
            var type = file.type;

            var output = document.getElementById('preview_img');


            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
