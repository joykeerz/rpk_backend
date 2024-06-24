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
            {{ $kategori->nama_kategori }}
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </h2>
    </header>

    <form enctype="multipart/form-data" action="{{ route('category.update', ['id' => $kategori->id]) }}" method="post">
        @csrf
        <div class="p-4 flex flex-col">
            <div class="p-4 grid grid-cols-2 gap-1 border rounded">
                <div id="namaProduk" class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Nama Category</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                        name="tb_nama_kategori" id="tb_nama_kategori" placeholder="" value="{{ $kategori->nama_kategori }}">
                    @error('tb_nama_kategori')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div id="deskripsiKategori" class="mb-3">
                    <label for="deskripsiKategori" class="block text-sm font-medium text-gray-700">Deskripsi
                        Kategori</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_desk_kategori" id="tb_desk_kategori" placeholder=""
                        value="{{ $kategori->deskripsi_kategori }}">
                    @error('tb_desk_kategori')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div id="externalIdKategori" class="mb-3">
                    <label for="externalIdKategori" class="block text-sm font-medium text-gray-700">ID Eksternal</label>
                    <input value="{{ $kategori->external_kategori_id }}" type="text" name="tb_external_id"
                        id="tb_external_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_external_id" id="tb_external_id">
                    @error('tb_external_id')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                    <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                </div>

                <div id="iconCategory" class="mb-3 mt-2">
                    <label for="iconCategory" class="block text-sm font-medium text-gray-700">Icon Category</label>
                    <img src="{{ asset('storage/' . $kategori->category_file_path) }}" id="preview_img"
                        class="h-fit w-full object-cover">
                    <input onchange="loadFile(event)" value="" type="file" name="file_icon_kategori"
                        id="file_icon_kategori"
                        class="mt-1 block w-full
                        rounded-md shadow-sm focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                        name="file_icon_kategori" id="file_icon_kategori">
                    @error('file_icon_kategori')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="buttonContainer flex justify-center p-4">
                <button type="submit" class="btn btn-sm bg-yellowlog text-neutral ">
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
