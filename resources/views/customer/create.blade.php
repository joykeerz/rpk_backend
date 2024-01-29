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
            {{ __('Input Customer') }}
        </h2>
    </header>

    @if (session('status'))
        <div class="bg-green-500 p-3 text-white rounded-lg mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 w-full mx-3">
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Perhatian!</strong>
                            <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
                        </div>
                        <form enctype="multipart/form-data" method="POST" action="{{ route('customer.store') }}">
                            <div class="flex w-full justify-between">
                                @csrf
                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Account</h4>
                                        <hr class="my-4">
                                        <div class="mb-4">
                                            <label for="tb_nama_user"
                                                class="block text-sm font-medium text-gray-700">Name*</label>
                                            <input value="{{ old('tb_nama_user') }}" id="tb_nama_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_nama_user"
                                                placeholder="">
                                            @error('tb_nama_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_email_user"
                                                class="block text-sm font-medium text-gray-700">Email*</label>
                                            <input value="{{ old('tb_email_user') }}" id="tb_email_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_email_user"
                                                placeholder="">
                                            @error('tb_email_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_password_user"
                                                class="block text-sm font-medium text-gray-700">Password*</label>
                                            <input value="{{ old('tb_password_user') }}" id="tb_password_user"
                                                type="password" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_password_user" placeholder="">
                                            @error('tb_password_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_hp_user" class="block text-sm font-medium text-gray-700">No.
                                                Handphone*</label>
                                            <input value="{{ old('tb_hp_user') }}" id="tb_hp_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_hp_user" placeholder="">
                                            @error('tb_hp_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <h4 class="text-lg font-semibold">RPK Info</h4>
                                            <hr class="my-4">
                                            <div class="mb-4">
                                                <label for="tb_nama_rpk"
                                                    class="leading-7 block text-sm font-medium text-gray-700">Nama
                                                    RPK*</label>
                                                <input value="{{ old('tb_nama_rpk') }}" type="text" id="tb_nama_rpk"
                                                    name="tb_nama_rpk"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_nama_rpk')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kode_customer"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Kode RPK*
                                                </label>
                                                <input value="{{ old('tb_kode_customer') }}" type="text"
                                                    name="tb_kode_customer" id="tb_kode_customer"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_kode_customer')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="cb_kode_company"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Entitas*
                                                </label>
                                                <select name="cb_kode_company" id="cb_kode_company"
                                                    class="mt-1 block w-full rounded-md  shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                                    @forelse ($entitas as $company)
                                                        <option value="{{ $company->kode_company }}">
                                                            {{ $company->nama_company }}
                                                        </option>
                                                    @empty
                                                        <option value="" disabled>
                                                            No data
                                                        </option>
                                                    @endforelse
                                                </select>
                                                @error('cb_kode_company')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                                <p class="text-gray-400 text-sm">
                                                    Mendaftarkan customer ke Kanwil
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="cb_branch_id"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Cabang*
                                                </label>
                                                <select name="cb_branch_id" id="cb_branch_id"
                                                    class="mt-1 block w-full rounded-md  shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                                    @forelse ($cabang as $branch)
                                                        <option value="{{ $branch->id }}">
                                                            {{ $branch->nama_branch }}
                                                        </option>
                                                    @empty
                                                        <option value="" disabled>
                                                            No data
                                                        </option>
                                                    @endforelse
                                                </select>
                                                @error('cb_branch_id')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                                <p class="text-gray-400 text-sm">
                                                    Mendaftarkan customer ke Cabang
                                                </p>
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_ktp_rpk"
                                                    class="leading-7 block text-sm font-medium text-gray-700">KTP
                                                    RPK*</label>
                                                <input value="{{ old('tb_ktp_rpk') }}" type="text" id="tb_ktp_rpk"
                                                    name="tb_ktp_rpk"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_ktp_rpk')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_img_ktp"
                                                    class="leading-7 block text-sm font-medium text-gray-700">KTP
                                                    Image*</label>
                                                <img id="preview_img" class="h-56 w-full object-cover">
                                                <input value="{{ old('tb_img_ktp') }}" onchange="loadFile(event)"
                                                    type="file" id="tb_img_ktp" name="tb_img_ktp"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_img_ktp')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Alamat</h4>
                                        <hr class="my-4">

                                        <div class="mb-4">
                                            <label for="tb_jalan"
                                                class="block text-sm font-medium text-gray-700">Jalan*</label>
                                            <input value="{{ old('tb_jalan') }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_jalan"
                                                placeholder="">
                                            @error('tb_jalan')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_jalan_2" class="block text-sm font-medium text-gray-700">Jalan
                                                2</label>
                                            <input value="{{ old('tb_jalan_2') }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_jalan_2"
                                                placeholder="">
                                            @error('tb_jalan_2')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_blok"
                                                class="block text-sm font-medium text-gray-700">Blok</label>
                                            <input value="{{ old('tb_blok') }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_blok" placeholder="">
                                            @error('tb_blok')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_rt"
                                                    class="block text-sm font-medium text-gray-700">RT</label>
                                                <input value="{{ old('tb_rt') }}" type="text"
                                                    class="border rounded-md py-2 px-3 w-full" name="tb_rt"
                                                    placeholder="">
                                                @error('tb_rt')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_rw"
                                                    class="block text-sm font-medium text-gray-700">RW</label>
                                                <input value="{{ old('tb_rw') }}" type="text"
                                                    class="border rounded-md py-2 px-3 w-full" name="tb_rw"
                                                    placeholder="">
                                                @error('tb_rw')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_prov"
                                                    class="block text-sm font-medium text-gray-700">Provinsi*</label>
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
                                                    class="block text-sm font-medium text-gray-700">Kota/Kabupaten*</label>
                                                <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota"
                                                    class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih Kota/Kabupaten</option>
                                                </select>
                                                @error('tb_kota')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_kecamatan"
                                                    class="block text-sm font-medium text-gray-700">Kecamatan*</label>
                                                <select onchange="loadKelurahan(event);" name="tb_kecamatan"
                                                    id="tb_kecamatan" class="border rounded-md py-2 px-3 w-full">
                                                    <option disabled selected>Pilih Kecamatan</option>
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
                                                Pos*</label>

                                            <input value="{{ old('tb_kodepos') }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_kodepos"
                                                placeholder="">
                                            @error('tb_kodepos')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Create
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
