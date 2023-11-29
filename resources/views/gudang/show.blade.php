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
    <header class="bg-gray-200 p-4">
        <h2>
            {{ $data['gudang']->nama_gudang }}
        </h2>
    </header>


    <form action="{{ route('gudang.update', ['id' => $data['gudang']->id]) }}" method="post">
        @csrf
        <div class="formContainer p-4 flex flex-wrap">
            <div class="namaGudang w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Nama Gudang</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_nama_gudang" id="tb_nama_gudang" placeholder="" value="{{ $data['gudang']->nama_gudang }}">
            </div>

            <div class="company_id w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Company ID</label>
                <select name="cb_company_id" id="cb_company_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                    @foreach ($data['companyData'] as $company)
                        <option value="{{ $company->id }}" @if ($company->id == $data['gudang']->company_id) selected @endif>
                            {{ $company->nama_company }}</option>
                    @endforeach
                </select>
            </div>

            <div class="user_id w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">User Penanggung Jawab</label>
                <select name="cb_user_id" id="cb_user_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                    @foreach ($data['usersData'] as $user)
                        <option value="{{ $user->id }}" @if ($user->id == $data['gudang']->user_id) selected @endif>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="jalan w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Jalan</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_jalan" id="tb_jalan" placeholder="" value="{{ $data['gudang']->jalan }}">
            </div>

            <div class="jalan_ext w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Jalan 2</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_jalan_ext" id="tb_jalan_ext" placeholder="" value="{{ $data['gudang']->jalan_ext }}">
            </div>

            <div class="blok w-1/2 p-2">
                <label for="tb_blok" class="block text-sm font-medium text-gray-700">Blok</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_blok" id="tb_blok" placeholder="" value="{{ $data['gudang']->blok }}">
            </div>

            <div class="rt w-1/2 p-2">
                <label for="tb_rt" class="block text-sm font-medium text-gray-700">RT</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_rt" id="tb_rt" placeholder="" value="{{ $data['gudang']->rt }}">
            </div>

            <div class="rw w-1/2 p-2">
                <label for="tb_rw" class="block text-sm font-medium text-gray-700">RW</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                    name="tb_rw" id="tb_rw" placeholder="" value="{{ $data['gudang']->rw }}">
            </div>

            <div class="provinsi w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <select onchange="loadKota(event);" name="tb_prov" id="tb_prov"
                    class="border rounded-md py-2 px-3 w-full">
                    <option disabled selected>Pilih Provinsi</option>
                </select>
            </div>

            <div class="kota w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota"
                    class="border rounded-md py-2 px-3 w-full">
                    <option disabled selected>Pilih Kota/Kabupaten</option>
                </select>
            </div>

            <div class="kecamatan w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select onchange="loadKelurahan(event);" name="tb_kecamatan" id="tb_kecamatan"
                    class="border rounded-md py-2 px-3 w-full">
                    <option disabled selected>Pilih Kecamatan</option>
                </select>
            </div>

            <div class="kelurahan w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="tb_kelurahan" id="tb_kelurahan" class="border rounded-md py-2 px-3 w-full">
                    <option disabled selected>Pilih Kelurahan</option>
                </select>
            </div>

            <div class="kodepos w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_kodepos" id="tb_kodepos" placeholder="" value="{{ $data['gudang']->kode_pos }}">
            </div>

            <div class="no_telp w-1/2 p-2">
                <label for="" class="block text-sm font-medium text-gray-700">No. Telp</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_no_telp" id="tb_no_telp" placeholder="" value="{{ $data['gudang']->no_telp }}">
            </div>

            <div class="external_id w-1/2 p-2">
                <label for="tb_external_id" class="block text-sm font-medium text-gray-700">ID External</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                    name="tb_external_id" id="tb_external_id" placeholder="" value="{{ $data['gudang']->no_telp }}">
            </div>

        </div>

        <div class="buttonContainer flex justify-center p-4">
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>

    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var id_prov_init;
            var id_kota_init;
            var id_kecamatan_init;
            var id_kelurahan_init;

            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $.each(result, function(key, value) {
                        if (value.name == "{{ $data['gudang']->provinsi }}") {
                            $('#tb_prov').append('<option selected data-id="' + value.id +
                                '">' + value
                                .name + '</option>');
                            id_prov_init = value.id;
                        }
                        $('#tb_prov').append('<option data-id="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            }).done(function() {
                $.ajax({
                    url: "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/" +
                        id_prov_init +
                        ".json",
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $.each(result, function(key, value) {
                            if (value.name == "{{ $data['gudang']->kota_kabupaten }}") {
                                $('#tb_kota').append('<option selected data-id="' +
                                    value.id +
                                    '">' + value
                                    .name + '</option>');
                                id_kota_init = value.id;
                            }
                            $('#tb_kota').append('<option data-id="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });
                    }
                }).done(function() {
                    $.ajax({
                        url: "https://www.emsifa.com/api-wilayah-indonesia/api/districts/" +
                            id_kota_init +
                            ".json",
                        type: "GET",
                        dataType: "json",
                        success: function(result) {
                            $.each(result, function(key, value) {
                                if (value.name ==
                                "{{ $data['gudang']->kecamatan }}") {
                                    $('#tb_kecamatan').append(
                                        '<option selected data-id="' +
                                        value.id +
                                        '">' + value
                                        .name + '</option>');
                                    id_kecamatan_init = value.id;
                                }
                                $('#tb_kecamatan').append('<option data-id="' +
                                    value.id + '">' +
                                    value
                                    .name + '</option>');
                            });
                        }
                    }).done(function() {
                        $.ajax({
                            url: "https://www.emsifa.com/api-wilayah-indonesia/api/villages/" +
                                id_kecamatan_init +
                                ".json",
                            type: "GET",
                            dataType: "json",
                            success: function(result) {
                                $.each(result, function(key, value) {
                                    if (value.name ==
                                    "{{ $data['gudang']->kelurahan }}") {
                                        $('#tb_kelurahan').append(
                                            '<option selected data-id="' +
                                            value.id +
                                            '">' + value
                                            .name + '</option>');
                                        id_kelurahan_init = value.id;
                                    }
                                    $('#tb_kelurahan').append(
                                        '<option data-id="' + value
                                        .id + '">' +
                                        value
                                        .name + '</option>');
                                });
                            }
                        })
                    })
                })
            });
        });
    </script>
    <script>
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
