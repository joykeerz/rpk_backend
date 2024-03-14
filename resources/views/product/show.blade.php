@extends('layouts.bar')

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection

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

    <form enctype="multipart/form-data" action="{{ route('product.update', ['id' => $product->pid]) }}" method="post">
        @csrf
        <div class="p-4 flex flex-col">
            <div class="p-4 grid grid-cols-2 gap-1 border rounded">
                <div id="namaProduk" class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                        name="tb_nama_produk" id="tb_nama_produk" placeholder="" value="{{ $product->nama_produk }}">
                    @error('tb_nama_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div id="displayProduk" class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Display Nama Produk</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                        name="tb_display_nama_produk" id="tb_display_nama_produk" placeholder=""
                        value="{{ $product->nama_display_produk }}">
                    @error('tb_display_nama_produk')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div id="kodeProduk" class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Kode Produk</label>
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
                <div id="diskonProduk" class="mb-3">
                    <label for="diskonProduk" class="block text-sm font-medium text-gray-700">
                        Diskon Produk(dalam persen)
                    </label>
                    <input value="{{ $product->diskon_produk }}" type="number" name="tb_diskon_produk"
                        id="tb_diskon_produk"
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
                        @forelse ($satuanData as $satuan)
                            <option value="{{ $satuan->id }}" @if ($satuan->id == $product->satuan_unit_id) selected @endif>
                                {{ $satuan->nama_satuan }}</option>

                        @empty
                            <option disabled>No Data</option>
                        @endforelse
                    </select>
                    @error('tb_satuan')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div id="pajakProduk" class="mb-3">
                    <label for="pajakProduk" class="block text-sm font-medium text-gray-700">Pajak</label>
                    <select id="tb_pajak" name="tb_pajak"
                        class="
                        block border w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                        <option disabled selected>Open this select menu</option>
                        @forelse ($pajakData as $pajak)
                            <option value="{{ $pajak->id }}" @if ($pajak->id == $product->pajak_id) selected @endif>
                                {{ $pajak->nama_pajak }}</option>
                        @empty
                            <option disabled>No Data</option>
                        @endforelse
                    </select>
                    @error('tb_pajak')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div id="externalIdProduk" class="mb-3">
                    <label for="externalIdProduk" class="block text-sm font-medium text-gray-700">ID Eksternal</label>
                    <input value="{{ $product->external_produk_id }}" type="text" name="tb_external_id"
                        id="tb_external_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                        name="tb_external_id" id="tb_external_id">
                    @error('tb_external_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                </div>

                <div id="imageProduk" class="mb-3 mt-2">
                    <label for="imageProduk" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <img src="{{ asset('storage/' . $product->produk_file_path) }}" id="preview_img"
                        class="h-fit w-full object-cover">
                    <input onchange="loadFile(event)" value="" type="file" name="file_image_produk"
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
            </div>

            <div class="buttonContainer flex justify-center p-4">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save
                </button>
            </div>
    </form>
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
    <script>
        $(function() {
            $("form").submit(function() {
                $('#loader').show();
            });
        });
    </script>
@endsection
