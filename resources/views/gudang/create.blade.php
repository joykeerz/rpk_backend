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
            {{ __('Input Gudang') }}
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{route('gudang.store')}}" method="POST" class="">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="tb_nama_gudang flex flex-col">
                    <label for="tb_nama_gudang">Nama Gudang</label>
                    <input type="text" name="tb_nama_gudang" id="tb_nama_gudang">
                </div>
                <div class="cb_company_id flex flex-col">
                    <label for="cb_company_id">Company</label>
                    <select name="cb_company_id" id="cb_company_id">
                        @foreach ($companyData as $company)
                            <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cb_user_id flex flex-col">
                    <label for="cb_user_id">User Penanggung Jawab</label>
                    <select name="cb_user_id" id="cb_user_id">
                        @foreach ($usersData as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tb_jalan flex flex-col">
                    <label for="tb_jalan">Jalan 1</label>
                    <input type="text" name="tb_jalan" id="tb_jalan">
                </div>
                <div class="tb_jalan_ext flex flex-col">
                    <label for="tb_jalan_ext">Jalan 2</label>
                    <input type="text" name="tb_jalan_ext" id="tb_jalan_ext">
                </div>
                <div class="tb_blok flex flex-col">
                    <label for="tb_blok">Blok</label>
                    <input type="text" name="tb_blok" id="tb_blok">
                </div>
                <div class="tb_rt flex flex-col">
                    <label for="tb_rt">RT</label>
                    <input type="text" name="tb_rt" id="tb_rt">
                </div>
                <div class="tb_rw flex flex-col">
                    <label for="tb_rw">RW</label>
                    <input type="text" name="tb_rw" id="tb_rw">
                </div>
                <div class="tb_kelurahan flex flex-col">
                    <label for="tb_kelurahan">Kelurahan</label>
                    <input type="text" name="tb_kelurahan" id="tb_kelurahan">
                </div>
                <div class="tb_kecamatan flex flex-col">
                    <label for="tb_kecamatan">Kecamatan</label>
                    <input type="text" name="tb_kecamatan" id="tb_kecamatan">
                </div>
                <div class="tb_kota_kabupaten flex flex-col">
                    <label for="tb_kota_kabupaten">Kota/Kabupaten</label>
                    <input type="text" name="tb_kota" id="tb_kota">
                </div>
                <div class="tb_provinsi flex flex-col">
                    <label for="tb_provinsi">Provinsi</label>
                    <input type="text" name="tb_prov" id="tb_prov">
                </div>
                <div class="tb_kode_pos flex flex-col">
                    <label for="tb_kode_pos">Kode Pos</label>
                    <input type="text" name="tb_kodepos" id="tb_kodepos">
                </div>
                <div class="tb_no_telp flex flex-col">
                    <label for="tb_no_telp">No. Telp</label>
                    <input type="text" name="tb_no_telp" id="tb_no_telp">
                </div>
                <div class="tb_external_id flex flex-col">
                    <label for="tb_external_id">ID External</label>
                    <input type="text" name="tb_external_id" id="tb_external_id">
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

        select{
            border: 1px solid #d2d6dc;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin: 0 3px;
        }
    </style>
@endsection
