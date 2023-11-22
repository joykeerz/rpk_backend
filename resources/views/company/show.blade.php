@extends('layouts.bar')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<header class="bg-gray-200 p-3">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detail Company {{ $company->nama_company }}
    </h2>
</header>

<div class="formContainer m-3 border rounded p-3">
    <form action="{{route('company.update', ['id'=>$company->cid])}}" method="post">
        @csrf
        <div class="formContainer grid grid-cols-2 gap-0.5">
            <div class="namaCompany">
                <label for="" class="block text-sm font-medium text-gray-700">Nama Company</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border p-1" name="tb_nama_company"
                    id="tb_nama_company" placeholder="" value="{{ $company->nama_company }}" >
            </div>

            <div class="penanggungJawab">
                <div class="penanggungJawab">
                    <label for="tb_user_id" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                    <select name="tb_user_id" id="tb_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                        @foreach ($usersData as $user)
                            <option value="{{ $user->id }}" @if ($user->id == $company->user_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="kodeCompany">
                <label for="" class="block text-sm font-medium text-gray-700">Kode Company</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kode_company"
                    id="tb_kode_company" placeholder="" value="{{ $company->kode_company }}" >
            </div>

            <div class="partnerCompany">
                <label for="" class="block text-sm font-medium text-gray-700">Partner Company</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_partner_company"
                    id="tb_partner_company" placeholder="" value="{{ $company->partner_company }}" >
            </div>

            <div class="taglineCompany">
                <label for="" class="block text-sm font-medium text-gray-700">Tagline Company</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_tagline_company"
                    id="tb_tagline_company" placeholder="" value="{{ $company->tagline_company }}" >
            </div>

            <div class="provinsi">
                <label for="" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_prov"
                    id="tb_provinsi" placeholder="" value="{{ $company->provinsi }}" >

            </div>

            <div class="kota">
                <label for="" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kota"
                    id="tb_kota" placeholder="" value="{{ $company->kota_kabupaten }}" >
            </div>

            <div class="jalan">
                <label for="" class="block text-sm font-medium text-gray-700">Jalan</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1" name="tb_jalan"
                    id="tb_jalan" placeholder="" value="{{ $company->jalan }}" >
            </div>

            <div class="jalan_ext">
                <label for="" class="block text-sm font-medium text-gray-700">Jalan 2</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring
                    focus:ring-indigo-200 focus:ring-opacity-50  border border-gray-300 p-1" name="tb_jalan_ext"
                    id="tb_jalan_ext" placeholder="" value="{{ $company->jalan_ext }}" >

            </div>

            <div class="blok">
                <label for="" class="block text-sm font-medium text-gray-700">Blok</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_blok"
                    id="tb_blok" placeholder="" value="{{ $company->blok }}" >
            </div>

            <div class="rt">
                <label for="" class="block text-sm font-medium text-gray-700">RT</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_rt"
                    id="tb_rt" placeholder="" value="{{ $company->rt }}" >
            </div>

            <div class="rw">
                <label for="" class="block text-sm font-medium text-gray-700">RW</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_rw"
                    id="tb_rw" placeholder="" value="{{ $company->rw }}" >
            </div>

            <div class="kelurahan">
                <label for="" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kelurahan"
                    id="tb_kelurahan" placeholder="" value="{{ $company->kelurahan }}" >
            </div>

            <div class="kecamatan">
                <label for="" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kecamatan"
                    id="tb_kecamatan" placeholder="" value="{{ $company->kecamatan }}" >
            </div>

            <div class="kodepos">
                <label for="" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                <input type="number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" name="tb_kodepos"
                    id="tb_kodepos" placeholder="" value="{{ $company->kode_pos }}" >
            </div>

            <div class="external_id">
                <label for="" class="block text-sm font-medium text-gray-700">ID External</label>
                <input type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-1" name="tb_external_id"
                    id="tb_external_id" placeholder="" value="{{ $company->external_company_id }}" >
            </div>
        </div>
        <div class="buttonContainer flex justify-center p-4">
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>
    </form>
</div>


@endsection
