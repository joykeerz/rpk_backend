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
            Ubah Pajak ({{ $pajak->nama_pajak }})
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">

        <form action="{{ route('pajak.update', ['id' => $pajak->id]) }}" method="post">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="namaPajak flex flex-col">
                    <label for="namaPajak">Nama Pajak</label>
                    <input value="{{ $pajak->nama_pajak }}" type="text" name="namaPajak" id="namaPajak">
                    @error('namaPajak')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="jenisPajak flex flex-col">
                    <label for="jenisPajak">Jenis pajak</label>
                    <select name="jenisPajak" id="jenisPajak" class="w-full max-w-xs">
                        <option disabled>Pilih jenis pajak...</option>
                        <option selected>{{ $pajak->jenis_pajak }}</option>
                        <option>Dibebaskan</option>
                        <option>Include</option>
                        <option>Exclude</option>
                    </select>
                    @error('jenisPajak')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="persentasePajak flex flex-col">
                    <label for="persentasePajak">Persentase (%)</label>
                    <input value="{{ $pajak->persentase_pajak }}" type="text" name="persentasePajak"
                        id="persentasePajak">
                    <label class="text-sm text-gray-400">Masukan tanpa simbol %</label>
                    @error('persentasePajak')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="idExternal flex flex-col">
                    <label for="idExternal">ID Eksternal</label>
                    <input value="{{ $pajak->external_pajak_id }}" type="text" name="idExternal" id="idExternal">
                </div>
            </div>

            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-yellowlog text-neutral py-2 px-4 rounded-md hover:bg-blue-600">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan
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
            margin-bottom: 16px;
            margin: 0 3px;
        }
    </style>
@endsection
