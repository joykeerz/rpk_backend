@extends('layouts.bar')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@section('content')
    <header class="bg-gray-200 p-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Company(Entitas)') }}
        </h2>
    </header>

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
    </div>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('company.store') }}" method="post">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="tb_nama_company flex flex-col">
                    <label for="tb_nama_company">Nama Entitas*</label>
                    <input value="{{ old('tb_nama_company') }}" type="text" name="tb_nama_company" id="tb_nama_company">
                    @error('tb_nama_company')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div class="tb_user_id flex flex-col">
                    <label for="tb_user_id">Penanggung Jawab*</label>
                    <select name="tb_user_id" id="tb_user_id">
                        @foreach ($usersData as $user)
                            <option value="{{ $user->id }}" {{ old('tb_user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('tb_user_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div> --}}
                <div class="tb_kode_company flex flex-col">
                    <label for="tb_kode_company">Kode Entitas*</label>
                    <input value="{{ old('tb_kode_company') }}" type="text" name="tb_kode_company" id="tb_kode_company">
                    @error('tb_kode_company')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <input value="kosong" type="hidden" name="tb_partner_company" id="tb_partner_company">
                @error('tb_partner_company')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <div class="tb_tagline_company flex flex-col">
                    <label for="tb_tagline_company">Tagline</label>
                    <input value="{{ old('tb_tagline_company') }}" type="text" name="tb_tagline_company"
                        id="tb_tagline_company">
                    @error('tb_tagline_company')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_jalan flex flex-col">
                    <label for="tb_jalan">Jalan*</label>
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
                <div class="tb_prov flex flex-col">
                    <label for="tb_prov">Provinsi*</label>
                    <select onchange="loadKota(event);" name="tb_prov" id="tb_prov">
                        @if (old('tb_prov'))
                            <option selected>{{ old('tb_prov') }}</option>
                        @else
                            <option disabled selected>Pilih Provinsi</option>
                        @endif
                    </select>
                    @error('tb_prov')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kota flex flex-col">
                    <label for="tb_kota">Kota/Kabupaten*</label>
                    <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota">
                        @if (old('tb_kota'))
                            <option selected>{{ old('tb_kota') }}</option>
                        @else
                            <option disabled selected>Pilih Kota/Kabupaten</option>
                        @endif

                    </select>
                    @error('tb_kota')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kecamatan flex flex-col">
                    <label for="tb_kecamatan">Kecamatan*</label>
                    <select onchange="loadKelurahan(event);" name="tb_kecamatan" id="tb_kecamatan">
                        @if (old('tb_kecamatan'))
                            <option selected>{{ old('tb_kecamatan') }}</option>
                        @else
                            <option disabled selected>Pilih Kecamatan</option>
                        @endif
                    </select>
                    @error('tb_kecamatan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kelurahan flex flex-col">
                    <label for="tb_kelurahan">Kecamatan*</label>
                    <select name="tb_kelurahan" id="tb_kelurahan">
                        @if (old('tb_kelurahan'))
                            <option selected>{{ old('tb_kelurahan') }}</option>
                        @else
                            <option disabled selected>Pilih Kelurahan</option>
                        @endif
                    </select>
                    @error('tb_kelurahan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_kodepos flex flex-col">
                    <label for="tb_kodepos">Kode Pos*</label>
                    <input value="{{ old('tb_kodepos') }}" type="text" name="tb_kodepos" id="tb_kodepos">
                    @error('tb_kodepos')
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
        input[type=text],
        select,
        textarea {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 3px 6px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
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
                    // $('#tb_prov').append(
                    //     "<option {{ old('tb_prov') == 'value.name' ? 'selected' : '' }}>{{ old('tb_prov') }}</option>"
                    //     );
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
