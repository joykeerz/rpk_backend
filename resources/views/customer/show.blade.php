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
            Detail Customer : {{ $customer->name }}
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </h2>
    </header>

    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 w-full mx-3">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('customer.update', ['id' => $customer->bid]) }}">
                            <div class="flex w-full justify-between">
                                @csrf
                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Account</h4>
                                        <hr class="my-4">
                                        <div class="mb-4">
                                            <label for="tb_nama_user"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input required id="tb_nama_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_nama_user"
                                                placeholder="" value="{{ $customer->name }}">
                                            @error('tb_nama_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_email_user"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input required id="tb_email_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_email_user"
                                                placeholder="" value="{{ $customer->email }}">
                                            @error('tb_email_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_hp_user" class="block text-sm font-medium text-gray-700">No.
                                                Handphone</label>
                                            <input required id="tb_hp_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_hp_user" placeholder=""
                                                value="{{ $customer->no_hp }}">
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
                                                    RPK</label>
                                                <input required type="text" id="tb_nama_rpk" name="tb_nama_rpk"
                                                    value="{{ $customer->nama_rpk }}"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">

                                                <label for="tb_kode_customer"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Kode RPK
                                                </label>
                                                <input type="text" name="tb_kode_customer" id=""
                                                    value="{{ $customer->kode_customer }}"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_kode_customer')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="cb_kode_company"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Entitas
                                                </label>
                                                <select name="cb_kode_company" id="cb_kode_company"
                                                    class="mt-1 block w-full rounded-md  shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                                    @forelse ($entitas as $company)
                                                        <option value="{{ $company->kode_company }}"
                                                            @if ($customer->kode_company == $company->kode_company) selected @endif>
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
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Cabang
                                                    Terdaftar
                                                </label>
                                                <select name="cb_branch_id" id="cb_branch_id"
                                                    class="mt-1 block w-full rounded-md  shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                                    @forelse ($cabang as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            @if ($customer->branch_id == $branch->id) selected @endif>
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
                                                    RPK</label>
                                                <input required type="text" id="tb_ktp_rpk" name="tb_ktp_rpk"
                                                    value="{{ $customer->no_ktp }}"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                                @error('tb_ktp_rpk')
                                                    @if ($message == 'The tb_ktp_rpk has already been taken.')
                                                        <p class="text-red-500 text-sm">KTP sudah terdaftar</p>
                                                    @else
                                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                                    @endif
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_img_ktp"
                                                    class="leading-7 block text-sm font-medium text-gray-700">KTP
                                                    IMG</label>
                                                <img src="{{ asset('storage/' . $customer->ktp_img) }}"
                                                    alt="image not found" class="h-56 w-full object-cover">
                                                <input type="file" id="tb_img_ktp" name="tb_img_ktp"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_img_npwp"
                                                    class="leading-7 block text-sm font-medium text-gray-700">NPWP
                                                    IMG</label>
                                                <img src="{{ asset('storage/' . $customer->npwp_img) }}"
                                                    alt="image not found" class="h-56 w-full object-cover">
                                                <input type="file" id="tb_img_npwp" name="tb_img_npwp"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_img_nib"
                                                    class="leading-7 block text-sm font-medium text-gray-700">NIB
                                                    IMG</label>
                                                <img src="{{ asset('storage/' . $customer->nib_img) }}"
                                                    alt="image not found" class="h-56 w-full object-cover">
                                                <input type="file" id="tb_img_nib" name="tb_img_nib"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <div class="flex justify-between">
                                            <h4 class="text-lg font-semibold">Alamat Aktif</h4>
                                            <div class="button">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('daftar-alamat.customer.index', ['id' => $customer->uid]) }}">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                    Daftar Alamat
                                                </a>
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="mb-4">
                                            <label for="tb_jalan"
                                                class="block text-sm font-medium text-gray-700">Jalan</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_jalan" value="{{ $customer->jalan }}" placeholder="">
                                            @error('tb_jalan')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror

                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_jalan_2" class="block text-sm font-medium text-gray-700">Jalan
                                                2</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                value="{{ $customer->jalan_ext }}" name="tb_jalan_2" placeholder="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_blok"
                                                class="block text-sm font-medium text-gray-700">Blok</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_blok" value="{{ $customer->blok }}" placeholder="">
                                            @error('tb_blok')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_rt"
                                                    class="block text-sm font-medium text-gray-700">RT</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ $customer->rt }}" name="tb_rt" placeholder="">
                                                @error('tb_rt')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_rw"
                                                    class="block text-sm font-medium text-gray-700">RW</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ $customer->rw }}" name="tb_rw" placeholder="">
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
                                                    <option class="bg-slate-400 text-white" selected
                                                        value="{{ $customer->provinsi_id }}">
                                                        {{ preg_replace('/^\d+\.\s/', '', $customer->provinsi_name) }}
                                                    </option>
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
                                                    <option class="bg-slate-400 text-white" selected
                                                        value="{{ $customer->kabupaten_id }}">
                                                        {{ $customer->kabupaten_name }}</option>
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
                                                    <option class="bg-slate-400 text-white" selected
                                                        value="{{ $customer->kecamatan_id }}">
                                                        {{ $customer->kecamatan_name }}</option>
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
                                                    <option class="bg-slate-400 text-white" selected
                                                        value="{{ $customer->kelurahan_id }}">
                                                        {{ $customer->kelurahan_name }}</option>
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
                                                value="{{ $customer->kode_pos }}" name="tb_kodepos" placeholder="">
                                            @error('tb_kodepos')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror


                                        </div>
                                        <button type="submit"
                                            class="bg-yellowlog text-neutral  py-2 px-4 rounded-md hover:bg-blue-600">Update
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
        $(document).ready(function() {
            var id_prov_init;
            var id_kota_init;
            var id_kecamatan_init;
            var id_kelurahan_init;

            $.ajax({
                url: "{{ env('API_MOBILE_URL') }}/daerah/provinsi/all",
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $.each(result, function(key, value) {
                        if (value.display_name == '{{ $customer->provinsi_name }}') {
                            $('#tb_prov').append('<option selected  data-id="' + value.id +
                                '" value="' + value.id + '">' + value.display_name +
                                '</option>');
                            id_prov_init = value.id;
                        }
                        $('#tb_prov').append('<option value="' + value.id + '" data-id="' +
                            value.id + '">' + value
                            .display_name + '</option>');
                    });
                }
            }).done(function() {
                $.ajax({
                    url: "{{ env('API_MOBILE_URL') }}/daerah/kabupaten/id/" + id_prov_init,
                    type: "GET",
                    dataType: "json",
                    success: function(result) {
                        $.each(result, function(key, value) {
                            if (value.display_name ==
                                '{{ $customer->kabupaten_name }}') {
                                $('#tb_kota').append('<option selected data-id="' +
                                    value.id + '" value="' + value.id + '">' + value
                                    .display_name + '</option>');
                                id_kota_init = value.id;
                            }
                            $('#tb_kota').append('<option value="' + value.id +
                                '" data-id="' + value.id + '">' +
                                value
                                .display_name + '</option>');
                        });
                    }
                }).done(function() {
                    $.ajax({
                        url: "{{ env('API_MOBILE_URL') }}/daerah/kecamatan/id/" +
                            id_kota_init,
                        type: "GET",
                        dataType: "json",
                        success: function(result) {
                            $.each(result, function(key, value) {
                                if (value.display_name ==
                                    '{{ $customer->kecamatan_name }}') {
                                    $('#tb_kecamatan').append(
                                        '<option selected data-id="' + value
                                        .id + '" value="' + value.id +
                                        '">' + value.display_name +
                                        '</option>');
                                    id_kecamatan_init = value.id;
                                }
                                $('#tb_kecamatan').append('<option value="' +
                                    value.id + '" data-id="' +
                                    value.id + '">' +
                                    value
                                    .display_name + '</option>');
                            });
                        }
                    }).done(function() {
                        $.ajax({
                            url: "{{ env('API_MOBILE_URL') }}/daerah/kelurahan/id/" +
                                id_kecamatan_init,
                            type: "GET",
                            dataType: "json",
                            success: function(result) {
                                $.each(result, function(key, value) {
                                    if (value.display_name ==
                                        '{{ $customer->kelurahan_name }}'
                                    ) {
                                        $('#tb_kelurahan').append(
                                            '<option selected data-id="' +
                                            value.id + '" value="' +
                                            value.id + '">' + value
                                            .display_name +
                                            '</option>');
                                        id_kelurahan_init = value.id;
                                    }
                                    $('#tb_kelurahan').append(
                                        '<option value="' + value
                                        .id + '" data-id="' + value
                                        .id + '">' +
                                        value
                                        .display_name +
                                        '</option>');
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
                url: "{{ env('API_MOBILE_URL') }}/daerah/kota/id/" + id_prov,
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
                        $('#tb_kota').append('<option value="' + value.id + '" data-id="' + value
                            .id + '">' + value
                            .display_name + '</option>');
                    });
                }
            });
        };

        var loadKecamatan = function(event) {
            var id_kota = $('#tb_kota').find(':selected').data('id');
            $.ajax({
                url: "{{ env('API_MOBILE_URL') }}/daerah/kecamatan/id/" + id_kota,
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#tb_kecamatan').empty();
                    $('#tb_kecamatan').append('<option disabled selected>Pilih Kecamatan</option>');
                    $('#tb_kelurahan').empty();
                    $('#tb_kelurahan').append('<option disabled selected>Pilih Kelurahan</option>');
                    $.each(result, function(key, value) {
                        $('#tb_kecamatan').append('<option value="' + value.id + '" data-id="' +
                            value.id + '">' + value
                            .display_name + '</option>');
                    });
                }
            });
        }

        var loadKelurahan = function(event) {
            var id_kecamatan = $('#tb_kecamatan').find(':selected').data('id');
            $.ajax({
                url: "{{ env('API_MOBILE_URL') }}/daerah/kelurahan/id/" + id_kecamatan,
                type: "GET",
                dataType: "json",
                success: function(result) {
                    $('#tb_kelurahan').empty();
                    $('#tb_kelurahan').append('<option disabled selected>Pilih Kelurahan</option>');
                    $.each(result, function(key, value) {
                        $('#tb_kelurahan').append('<option value="' + value.id + '" data-id="' +
                            value.id + '">' + value
                            .display_name + '</option>');
                    });
                }
            });
        }
    </script>
@endsection
