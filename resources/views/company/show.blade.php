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
            Detail Company {{ $company->nama_company }}
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('company.update', ['id' => $company->cid]) }}" method="post">
            @csrf
            <div class="formContainer grid grid-cols-2 gap-0.5">
                <div class="namaCompany">
                    <label for="" class="block text-sm font-medium text-gray-700">Nama Company</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_nama_company" id="tb_nama_company" placeholder="" value="{{ $company->nama_company }}">
                </div>

                {{-- <div class="penanggungJawab">
                    <div class="penanggungJawab">
                        <label for="tb_user_id" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                        <select name="tb_user_id" id="tb_user_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1">
                            @foreach ($usersData as $user)
                                <option value="{{ $user->id }}" @if ($user->id == $company->user_id) selected @endif>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <div class="kodeCompany">
                    <label for="" class="block text-sm font-medium text-gray-700">Kode Company</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_kode_company" id="tb_kode_company" placeholder="" value="{{ $company->kode_company }}">
                </div>

                <div class="partnerCompany">
                    <label for="" class="block text-sm font-medium text-gray-700">Partner Company</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_partner_company" id="tb_partner_company" placeholder=""
                        value="{{ $company->partner_company }}">
                </div>

                <div class="taglineCompany">
                    <label for="" class="block text-sm font-medium text-gray-700">Tagline Company</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border p-1ne_company"
                        id="tb_tagline_company" name="tb_tagline_company" placeholder=""
                        value="{{ $company->tagline_company }}">
                </div>

                <div class="jalan">
                    <label for="" class="block text-sm font-medium text-gray-700">Jalan</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                        name="tb_jalan" id="tb_jalan" placeholder="" value="{{ $company->jalan }}">
                </div>

                <div class="jalan_ext">
                    <label for="" class="block text-sm font-medium text-gray-700">Jalan 2</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50  border p-1"
                        name="tb_jalan_ext" id="tb_jalan_ext" placeholder="" value="{{ $company->jalan_ext }}">

                </div>

                <div class="blok">
                    <label for="" class="block text-sm font-medium text-gray-700">Blok</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_blok" id="tb_blok" placeholder="" value="{{ $company->blok }}">
                </div>

                <div class="rt">
                    <label for="" class="block text-sm font-medium text-gray-700">RT</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_rt" id="tb_rt" placeholder="" value="{{ $company->rt }}">
                </div>

                <div class="rw">
                    <label for="" class="block text-sm font-medium text-gray-700">RW</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_rw" id="tb_rw" placeholder="" value="{{ $company->rw }}">
                </div>

                <div class="provinsi">
                    <label for="" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <select onchange="loadKota(event);" name="tb_prov" id="tb_prov"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Provinsi</option>
                    </select>
                </div>

                <div class="kota">
                    <label for="" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                    <select onchange="loadKecamatan(event);" name="tb_kota" id="tb_kota"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kota/Kabupaten</option>
                    </select>
                </div>

                <div class="kecamatan">
                    <label for="" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <select onchange="loadKelurahan(event);" name="tb_kecamatan" id="tb_kecamatan"
                        class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kecamatan</option>
                    </select>
                </div>

                <div class="kelurahan">
                    <label for="" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="tb_kelurahan" id="tb_kelurahan" class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Kelurahan</option>
                    </select>
                </div>

                <div class="kodepos">
                    <label for="" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                        name="tb_kodepos" id="tb_kodepos" placeholder="" value="{{ $company->kode_pos }}">
                </div>

                <div class="external_id">
                    <label for="" class="block text-sm font-medium text-gray-700">ID External</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="tb_external_id" id="tb_external_id" placeholder=""
                        value="{{ $company->external_company_id }}">
                </div>

                <div class="pricelist_id">
                    <label for="pricelist_id" class="block text-sm font-medium text-gray-700">Pricelist ID</label>
                    <input readonly type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1"
                        name="pricelist_id" id="pricelist_id" placeholder="pricelist"
                        value="{{ $company->pricelist_id }}">
                </div>

                <div class="rekening_tujuan_id">
                    <label for="rekening_tujuan_id" class="block text-sm font-medium text-gray-700">Rekening Tujuan
                        (Aktif)</label>
                    <select name="rekening_tujuan_id" id="rekening_tujuan_id" class="border rounded-md py-2 px-3 w-full">
                        <option disabled selected>Pilih Rekening Tujuan</option>
                        @forelse ($rekening as $rek)
                            <option value="{{ $rek->id }}"
                                {{ $rek->company_id == $company->cid ? 'selected' : '' }}>
                                {{ $rek->name }} - {{ $rek->bank_acc_number }}
                            </option>
                        @empty
                            <option disabled selected>No Data</option>
                        @endforelse
                    </select>

                </div>


            </div>
            <div class="buttonContainer flex justify-center p-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
            </div>
        </form>
    </div>
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
                        if (value.name == '{{ $company->provinsi }}') {
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
                            if (value.name == '{{ $company->kota_kabupaten }}') {
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
                                    '{{ $company->kecamatan }}') {
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
                                        '{{ $company->kelurahan }}') {
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
