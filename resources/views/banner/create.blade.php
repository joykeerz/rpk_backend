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
                New Banner
            </div>

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
                <strong class="font-bold">Perhatian!</strong>
                <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
            </div>

            <div class="formContainer m-3 border rounded p-3">
                <form enctype="multipart/form-data" action="{{ Route('banner.store') }}" method="post">
                    @csrf
                    <div>
                        <div class="p-4 grid grid-cols-2 gap-1">
                            <div id="judulBanner" class="mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700">Judul Banner*</label>
                                <input value="{{old('judul_banner')}}" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="judul_banner" id="judul_banner" placeholder="">
                                @error('judul_banner')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="deksripsiBanner" class="mb-3">
                                <label for="deskripsi_banner" class="block text-sm font-medium text-gray-700">Deskripsi
                                    Banner*</label>
                                <input value="{{old('deskripsi_banner')}}" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                                    name="deskripsi_banner" id="deskripsi_banner" placeholder="">
                                @error('deskripsi_banner')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="externalId" class="mb-3">
                                <label for="ExternalId" class="block text-sm font-medium text-gray-700">ID
                                    Eksternal</label>
                                <input value="{{old('external_id')}}" type="text" name="external_id" id="external_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                                    name="external_id" id="external_id">
                                @error('external_id')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                                <small id="helpId" class="text-gray-500 text-xs">boleh dikosongkan</small>
                            </div>
                            <div id="imageBanner" class="mb-3">
                                <label for="imageBanner" class="block text-sm font-medium text-gray-700">Gambar
                                    Banner*</label>
                                <img id="preview_img" class="h-fit w-full object-cover">
                                <input value="{{old('gambar_banner')}}" onchange="loadFile(event)" value="0" type="file" name="gambar_banner"
                                    id="gambar_banner"
                                    class="mt-1 block w-full
                                    rounded-md shadow-sm focus:border-indigo-300 focus:ring
                                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                    name="gambar_banner" id="gambar_banner">
                                @error('gambar_banner')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
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
