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
            Buat Satuan Unit Baru
        </h2>
    </header>

    <div class="formContainer m-3 border rounded p-3">

        <form action="{{ route('satuan-unit.store') }}" method="post">
            @csrf
            <div class="inputLabelContainer grid grid-cols-2 gap-0.5">
                <div class="namaSatuan flex flex-col">
                    <label for="namaSatuan">Nama Satuan</label>
                    <input type="text" name="namaSatuan" id="namaSatuan">
                    @error('namaSatuan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="simbolSatuan flex flex-col">
                    <label for="simbolSatuan">Simbol Satuan</label>
                    <input type="text" name="simbolSatuan" id="simbolSatuan">
                    @error('simbolSatuan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="keteranganSatuan flex flex-col">
                    <label for="keteranganSatuan">Keterangan</label>
                    <input type="text" name="keteranganSatuan" id="keteranganSatuan">
                    @error('keteranganSatuan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="idExternal flex flex-col">
                    <label for="idExternal">ID Eksternal</label>
                    <input type="text" name="idExternal" id="idExternal">
                </div>
            </div>

            <div class="flex justify-center my-3"> <!-- Flex container to center the button -->
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Create
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
