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
            Tambah Alamat
            {{-- @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach --}}
        </h2>
    </header>

    @include('layouts.alert')

    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 w-full mx-3">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('daftar-alamat.customer.insert', ['id' => $userID]) }}">
                            <div class="flex w-full justify-between">
                                @csrf
                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Form Alamat</h4>
                                        <hr class="my-4">
                                        <div class="mb-4">
                                            <label for="tb_jalan"
                                                class="block text-sm font-medium text-gray-700">Jalan</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full" name="tb_jalan"
                                                value="{{ old('tb_jalan') }}" placeholder="">
                                            @error('tb_jalan')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror

                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_jalan_2" class="block text-sm font-medium text-gray-700">Jalan
                                                2</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                value="{{ old('tb_jalan_2') }}" name="tb_jalan_2" placeholder="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_blok"
                                                class="block text-sm font-medium text-gray-700">Blok</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full" name="tb_blok"
                                                value="{{ old('tb_blok') }}" placeholder="">
                                            @error('tb_blok')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_rt"
                                                    class="block text-sm font-medium text-gray-700">RT</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ old('tb_rt') }}" name="tb_rt" placeholder="">
                                                @error('tb_rt')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_rw"
                                                    class="block text-sm font-medium text-gray-700">RW</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ old('tb_rw') }}" name="tb_rw" placeholder="">
                                                @error('tb_rw')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_prov"
                                                    class="block text-sm font-medium text-gray-700">Provinsi</label>

                                                <select onchange="loadKota(event);" name="tb_prov" id="tb_prov"
                                                    class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih Provinsi</option>
                                                </select>

                                                @error('tb_prov')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kota"
                                                    class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>

                                                <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota"
                                                    class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih Kota</option>
                                                </select>

                                                @error('tb_kota')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_kecamatan"
                                                    class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                                <select onchange="loadKelurahan(event);" name="tb_kecamatan"
                                                    id="tb_kecamatan" class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih kecamatan</option>
                                                </select>
                                                @error('tb_kecamatan')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kelurahan"
                                                    class="block text-sm font-medium text-gray-700">Kelurahan</label>
                                                <select name="tb_kelurahan" id="tb_kelurahan"
                                                    class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih Kelurahan</option>
                                                </select>
                                                @error('tb_kelurahan')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_kodepos" class="block text-sm font-medium text-gray-700">Kode
                                                Pos</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                value="{{ old('tb_kodepos') }}" name="tb_kodepos" placeholder="">
                                            @error('tb_kodepos')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror


                                        </div>
                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Save
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
