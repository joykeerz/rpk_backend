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
            Detail branch {{ $branch->nama_branch }}
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('branch.update', ['id' => $branch->bid]) }}" method="post">
            @csrf
            <div class="formContainer ">
                <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                    <div class="tb_nama_branch flex flex-col">
                        <label for="tb_nama_branch">Nama Branch</label>
                        <input type="text" name="tb_nama_branch" id="tb_nama_branch" value="{{ $branch->nama_branch }}">
                    </div>
                    <div class="cb_company_id flex flex-col">
                        <label for="cb_company_id">Nama Kantor Wilayah</label>
                        <select name="cb_company_id" id="cb_company_id">
                            <option disabled value="{{ $branch->company_id }}">Current: {{ $branch->nama_company }}</option>
                            @foreach ($companyData as $company)
                                <option value="{{ $company->id }}">{{ $company->nama_company }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tb_no_telp_branch flex flex-col">
                        <label for="tb_no_telp_branch">No Telp</label>
                        <input type="text" name="tb_no_telp_branch" id="tb_no_telp_branch"
                            value="{{ $branch->no_telp_branch }}">
                    </div>
                    <div class="tb_alamat_branch flex flex-col">
                        <label for="tb_alamat_branch">Alamat</label>
                        <input type="text" name="tb_alamat_branch" id="tb_alamat_branch"
                            value="{{ $branch->alamat_branch }}">
                    </div>
                    <div class="tb_id_external flex flex-col">
                        <label for="tb_id_external">ID Eksternal</label>
                        <input value="{{$branch->external_branch_id}}" type="text" name="tb_id_external" id="tb_id_external">
                    </div>
                </div>
            </div>


            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Update
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
        }
    </style>
@endsection
