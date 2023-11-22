@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<header class="bg-gray-200 p-4">
    <h2>
        {{ $data['gudang']->nama_gudang }}
    </h2>
</header>


<form action="{{route('gudang.update', ['id'=> $data['gudang']->id] )}}" method="post">
    @csrf
    <div class="formContainer p-4 flex flex-wrap">
        <div class="namaGudang w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Nama Gudang</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                name="tb_nama_gudang" id="tb_nama_gudang" placeholder="" value="{{ $data['gudang']->nama_gudang }}">
        </div>
        {{-- alamat gudang siapa bang --}}

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
            <label for="" class="block text-sm font-medium text-gray-700">User ID</label>
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

        <div class="provinsi w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Provinsi</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                name="tb_prov" id="tb_prov" placeholder="" value="{{ $data['gudang']->provinsi }}">
        </div>

        <div class="kota w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                name="tb_kota" id="tb_kota" placeholder="" value="{{ $data['gudang']->kota_kabupaten }}">
        </div>

        <div class="kecamatan w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Kecamatan</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                name="tb_kecamatan" id="tb_kecamatan" placeholder="" value="{{ $data['gudang']->kecamatan }}">
        </div>

        <div class="kelurahan w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Kelurahan</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1"
                name="tb_kelurahan" id="tb_kelurahan" placeholder="" value="{{ $data['gudang']->kelurahan }}">
        </div>

        <div class="kodepos w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">Kode Pos</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kodepos"
                id="tb_kodepos" placeholder="" value="{{ $data['gudang']->kode_pos }}">
        </div>

        <div class="no_telp w-1/2 p-2">
            <label for="" class="block text-sm font-medium text-gray-700">No. Telp</label>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_no_telp"
                id="tb_no_telp" placeholder="" value="{{ $data['gudang']->no_telp }}">
        </div>

    </div>

    <div class="buttonContainer flex justify-center p-4">
        <button type="submit"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </div>

</form>

@endsection
