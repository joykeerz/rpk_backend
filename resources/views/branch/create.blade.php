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

    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <span class="block sm:inline">Pastikan semua data bersimbol * terisi dengan benar</span>
    </div>

    <div class="formContainer m-3 border rounded p-3">
        <form action="{{ route('branch.store') }}" method="post">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="cb_company_id flex flex-col">
                    <label for="cb_company_id">Kantor Wilayah (Company)*</label>
                    <select name="cb_company_id" id="cb_company_id">
                        @foreach ($companyData as $item)
                            <option value="{{ $item->id }}" {{ old('cb_company_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_company }}</option>
                        @endforeach
                    </select>
                    @error('cb_company_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_name_branch flex flex-col">
                    <label for="tb_name_branch">Nama Branch*</label>
                    <input value="{{ old('tb_nama_branch') }}" type="text" name="tb_nama_branch" id="tb_nama_branch">
                    @error('tb_nama_branch')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_no_telp_branch flex flex-col">
                    <label for="tb_no_telp_branch">No Telp*</label>
                    <input value="{{ old('tb_no_telp_branch') }}" type="text" name="tb_no_telp_branch"
                        id="tb_no_telp_branch">
                    @error('tb_no_telp_branch')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_alamat_branch flex flex-col">
                    <label for="tb_alamat_branch">Alamat*</label>
                    <textarea name="tb_alamat_branch" id="tb_alamat_branch" cols="30" rows="2">{{ old('tb_alamat_branch') }}</textarea>
                    @error('tb_alamat_branch')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="tb_id_external flex flex-col">
                    <label for="tb_id_external">ID Eksternal</label>
                    <input value="{{ old('tb_id_external') }}" type="text" name="tb_id_external" id="tb_id_external">
                    @error('tb_id_external')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-yellowlog text-neutral py-2 px-4 rounded-md hover:bg-blue-600">
                    Create
                </button>
            </div>
        </form>
    </div>

    <style>
        input[type=text],
        input[type=email],
        input[type=number],
        input[type=date],
        input[type=tel],
        select,
        textarea {
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
