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
                New Article/Berita
            </div>

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
                <strong class="font-bold">Perhatian!</strong>
                <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
            </div>

            <div class="formContainer m-3 border rounded p-3">
                <form enctype="multipart/form-data" action="{{ Route('berita.store') }}" method="post">
                    @csrf
                    <div>
                        <div class="p-4 grid grid-cols-2 gap-1">
                            <div id="judulBerita" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Judul Berita*</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="judul_berita" id="judul_berita" placeholder="">
                                @error('judul_berita')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="penulisBerita" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Penulis
                                    Berita*</label>
                                <input type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="penulis_berita" id="penulis_berita" placeholder="">
                                @error('penulis_berita')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="kategoriBerita" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Kategori
                                    Berita*
                                </label>
                                <select
                                    class=" block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="kategori_berita" id="kategori_berita">
                                    <option>Pemberitahuan</option>
                                    <option>Artikel</option>
                                    <option>Promo</option>
                                    <option>Event</option>
                                </select>
                                @error('penulis_berita')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="externalId" class="mb-3">
                                <label for="ExternalId" class="block text-sm font-medium text-gray-700">ID
                                    Eksternal
                                </label>
                                <input type="text" name="external_id" id="external_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                                    name="external_id" id="external_id">
                                @error('external_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                                <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                            </div>
                            <div id="imageBerita" class="mb-3">
                                <label for="imageBerita" class="block text-sm font-medium text-gray-700">Gambar
                                    Banner*
                                </label>
                                <img id="preview_img" class="h-fit w-full object-cover">
                                <input onchange="loadFile(event)" value="0" type="file" name="gambar_berita"
                                    id="gambar_berita"
                                    class="mt-1 block w-full
                                    rounded-md shadow-sm focus:border-indigo-300 focus:ring
                                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                    name="gambar_berita" id="gambar_berita">
                                @error('gambar_berita')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror

                            </div>

                            <div id="deksripsiBerita" class="mb-3">
                                <label for="deskripsi_berita" class="block text-sm font-medium text-gray-700">Isi
                                    Berita*
                                </label>
                                <textarea
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="deskripsi_berita" id="deskripsi_berita" cols="30" rows="2"></textarea>

                                @error('deskripsi_berita')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="buttonContainer flex justify-center">
                            <button type="submit"
                                class="bg-yellowlog text-neutral px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200">
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
