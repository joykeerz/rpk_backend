@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
    <header class="bg-gray-200 p-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Location') }}
        </h2>
    </header>

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
    </div>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('location.store') }}" method="POST" class="">
            @csrf

            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <input type="hidden" name="tb_gudang_id" id="tb_gudang_id" value="{{ $gudangID }}">
                <div class="tb_nama_location flex flex-col">
                    <label for="tb_nama_location">Nama Location*</label>
                    <input value="{{ old('tb_nama_location') }}" type="text" name="tb_nama_location"
                        id="tb_nama_location">
                    @error('tb_nama_location')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_parent_location flex flex-col">
                    <label for="tb_parent_location">Parent Location</label>
                    <input value="{{ old('tb_parent_location') }}" type="text" name="tb_parent_location"
                        id="tb_parent_location">
                    @error('tb_parent_location')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_external_id flex flex-col">
                    <label for="tb_external_id">ID External</label>
                    <input value="{{ old('tb_external_id') }}" type="text" name="tb_external_id" id="tb_external_id">
                    @error('tb_external_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    <i class="fa-solid fa-floppy-disk m-1"></i>
                    Buat
                </button>
            </div>
        </form>
    </div>

    <style>
        input {
            border: 1px solid #d2d6dc;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin: 0 3px;
        }

        label {
            margin: 0 3px;
        }

        select {
            border: 1px solid #d2d6dc;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin: 0 3px;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $.each(result, function(key, value) {
                        $('#tb_prov').append('<option data-id="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        });

        var loadKota = function(event) {
            var id_prov = $('#tb_prov').find(':selected').data('id');
            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/" + id_prov +
                    ".json",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#tb_kota').empty();
                    $('#tb_kecamatan').empty();
                    $('#tb_kelurahan').empty();
                    $('#tb_kota').append('<option disabled selected>Pilih Kota/Kabupaten</option>');
                    $('#tb_kecamatan').append('<option disabled selected>Pilih Kecamatan</option>');
                    $('#tb_kelurahan').append('<option disabled selected>Pilih Kelurahan</option>');
                    $.each(result, function(key, value) {
                        $('#tb_kota').append('<option data-id="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        };

        var loadKecamatan = function(event) {
            var id_kota = $('#tb_kota').find(':selected').data('id');
            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/districts/" + id_kota +
                    ".json",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#tb_kecamatan').empty();
                    $('#tb_kecamatan').append('<option disabled selected>Pilih Kecamatan</option>');
                    $('#tb_kelurahan').empty();
                    $('#tb_kelurahan').append('<option disabled selected>Pilih Kelurahan</option>');
                    $.each(result, function(key, value) {
                        $('#tb_kecamatan').append('<option data-id="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        }

        var loadKelurahan = function(event) {
            var id_kecamatan = $('#tb_kecamatan').find(':selected').data('id');
            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/villages/" + id_kecamatan +
                    ".json",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#tb_kelurahan').empty();
                    $('#tb_kelurahan').append('<option disabled selected>Pilih Kelurahan</option>');
                    $.each(result, function(key, value) {
                        $('#tb_kelurahan').append('<option data-id="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        }
    </script>
@endsection
