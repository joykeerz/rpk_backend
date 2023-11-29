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
            {{ __('Input Gudang') }}
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('gudang.store') }}" method="POST" class="">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="tb_nama_gudang flex flex-col">
                    <label for="tb_nama_gudang">Nama Gudang*</label>
                    <input value="{{ old('tb_nama_gudang') }}" type="text" name="tb_nama_gudang" id="tb_nama_gudang">
                    @error('tb_nama_gudang')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="cb_company_id flex flex-col">
                    <label for="cb_company_id">Company*</label>
                    <select name="cb_company_id" id="cb_company_id">
                        @foreach ($companyData as $company)
                            <option value="{{ $company->id }}"
                                {{ old('cb_company_id') == $company->id ? 'selected' : '' }}>{{ $company->nama_company }}
                            </option>
                        @endforeach
                    </select>
                    @error('cb_company_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="cb_user_id flex flex-col">
                    <label for="cb_user_id">User Penanggung Jawab*</label>
                    <select name="cb_user_id" id="cb_user_id">
                        @foreach ($usersData as $user)
                            <option value="{{ $user->id }}" {{ old('cb_user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tb_jalan flex flex-col">
                    <label for="tb_jalan">Jalan 1*</label>
                    <input value="{{ old('tb_jalan') }}" type="text" name="tb_jalan" id="tb_jalan">
                    @error('tb_jalan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_jalan_ext flex flex-col">
                    <label for="tb_jalan_ext">Jalan 2</label>
                    <input value="{{ old('tb_jalan_ext') }}" type="text" name="tb_jalan_ext" id="tb_jalan_ext">
                    @error('tb_jalan_ext')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_blok flex flex-col">
                    <label for="tb_blok">Blok</label>
                    <input value="{{ old('tb_blok') }}" type="text" name="tb_blok" id="tb_blok">
                    @error('tb_blok')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_rt flex flex-col">
                    <label for="tb_rt">RT</label>
                    <input value="{{ old('tb_rt') }}" type="text" name="tb_rt" id="tb_rt">
                    @error('tb_rt')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_rw flex flex-col">
                    <label for="tb_rw">RW</label>
                    <input value="{{ old('tb_rw') }}" type="text" name="tb_rw" id="tb_rw">
                    @error('tb_rw')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_provinsi flex flex-col">
                    <label for="tb_provinsi">Provinsi*</label>
                    <select onchange="loadKota(event);" name="tb_prov" id="tb_prov"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Provinsi</option>
                    </select>
                    @error('tb_prov')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kota_kabupaten flex flex-col">
                    <label for="tb_kota_kabupaten">Kota/Kabupaten*</label>
                    <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kota/Kabupaten</option>
                    </select>
                    @error('tb_kota')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kecamatan flex flex-col">
                    <label for="tb_kecamatan">Kecamatan*</label>
                    <select onchange="loadKelurahan(event);" name="tb_kecamatan" id="tb_kecamatan"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kecamatan</option>
                    </select>
                    @error('tb_kecamatan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kelurahan flex flex-col">
                    <label for="tb_kelurahan">Kelurahan</label>
                    <select name="tb_kelurahan" id="tb_kelurahan" class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kelurahan</option>
                    </select>
                    @error('tb_kelurahan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kode_pos flex flex-col">
                    <label for="tb_kode_pos">Kode Pos*</label>
                    <input value="{{ old('tb_kode_pos') }}" type="text" name="tb_kodepos" id="tb_kodepos">
                    @error('tb_kodepos')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_no_telp flex flex-col">
                    <label for="tb_no_telp">No. Telp*</label>
                    <input value="{{ old('tb_no_telp') }}" type="text" name="tb_no_telp" id="tb_no_telp">
                    @error('tb_no_telp')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_external_id flex flex-col">
                    <label for="tb_external_id">ID External</label>
                    <input value="{{ old('tb_external_id') }}" type="text" name="tb_external_id"
                        id="tb_external_id">
                    @error('tb_external_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Create
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
