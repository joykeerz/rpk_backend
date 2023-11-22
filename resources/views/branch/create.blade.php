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
        Buat Cabang Baru (Branch)
    </h2>
</header>

<div class="formContainer m-3 border rounded p-3">
    <form action="{{route('branch.store')}}" method="post">
        @csrf
        <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
            <div class="cb_company_id flex flex-col">
                <label for="cb_company_id">Kantor Wilayah (Company)</label>
                <select name="cb_company_id" id="cb_company_id">
                    @foreach ($companyData as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_company }}</option>
                    @endforeach
                </select>
            </div>
            <div class="tb_name_branch flex flex-col">
                <label for="tb_name_branch">Nama Branch</label>
                <input type="text" name="tb_nama_branch" id="tb_nama_branch">
            </div>
            <div class="tb_no_telp flex flex-col">
                <label for="tb_no_telp">No Telp</label>
                <input type="text" name="tb_no_telp_branch" id="tb_no_telp_branch">
            </div>
            <div class="tb_alamat_branch flex flex-col">
                <label for="tb_alamat_branch">Alamat</label>
                <input type="text" name="tb_alamat_branch" id="tb_alamat_branch">
            </div>
            <div class="tb_id_external flex flex-col">
                <label for="tb_id_external">ID Eksternal</label>
                <input type="text" name="tb_id_external" id="tb_id_external">
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
    input[type=text], select, textarea  {
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
