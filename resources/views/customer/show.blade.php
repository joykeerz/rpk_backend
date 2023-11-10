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
            Detail Customer : {{ $customer->name }}
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        </h2>
    </header>

    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 w-full mx-3">
                        <form method="POST" action="{{ route('customer.update', ['id' => $customer->bid]) }}">
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
                                                <input type="file" id="tb_img_ktp" name="tb_img_ktp"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Alamat</h4>
                                        <hr class="my-4">
                                        <div class="mb-4">
                                            <label for="tb_jalan"
                                                class="block text-sm font-medium text-gray-700">Jalan</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full" name="tb_jalan"
                                                value="{{ $customer->jalan }}" placeholder="">
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

                                                <input type="text" name="tb_prov" id="tb_prov"
                                                    value="{{ $customer->provinsi }}"
                                                    class="border rounded-md py-2 px-3 w-full">

                                                @error('tb_prov')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kota"
                                                    class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ $customer->kota_kabupaten }}" name="tb_kota"
                                                    placeholder="">
                                                @error('tb_kota')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_kecamatan"
                                                    class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ $customer->kecamatan }}" name="tb_kecamatan"
                                                    placeholder="">
                                                @error('tb_kecamatan')
                                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kelurahan"
                                                    class="block text-sm font-medium text-gray-700">Kelurahan</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    value="{{ $customer->kelurahan }}" name="tb_kelurahan"
                                                    placeholder="">
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
                                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update
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
