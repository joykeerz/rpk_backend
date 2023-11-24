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
            {{ __('Input Customer') }}
        </h2>
    </header>

    @if (session('status'))
        <div class="bg-green-500 p-3 text-white rounded-lg mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 w-full mx-3">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('customer.store') }}">
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
                                                placeholder="">
                                            @error('tb_nama_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_email_user"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input required id="tb_email_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_email_user"
                                                placeholder="">
                                            @error('tb_email_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_password_user"
                                                class="block text-sm font-medium text-gray-700">Password</label>
                                            <input required id="tb_password_user" type="password"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_password_user"
                                                placeholder="">
                                            @error('tb_password_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_hp_user" class="block text-sm font-medium text-gray-700">No.
                                                Handphone</label>
                                            <input required id="tb_hp_user" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_hp_user" placeholder="">
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
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kode_customer"
                                                    class="leading-7 block text-sm font-medium text-gray-700"> Kode RPK
                                                </label>
                                                <input type="text" name="tb_kode_customer" id=""
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_ktp_rpk"
                                                    class="leading-7 block text-sm font-medium text-gray-700">KTP
                                                    RPK</label>
                                                <input required type="text" id="tb_ktp_rpk" name="tb_ktp_rpk"
                                                    class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-scolors duration-200 ease-in-out">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_img_ktp"
                                                    class="leading-7 block text-sm font-medium text-gray-700">KTP
                                                    IMG</label>
                                                <img id="preview_img" class="h-56 w-full object-cover">
                                                <input onchange="loadFile(event)" type="file" id="tb_img_ktp" name="tb_img_ktp"
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
                                                placeholder="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_jalan_2" class="block text-sm font-medium text-gray-700">Jalan
                                                2</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_jalan_2" placeholder="">
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_blok"
                                                class="block text-sm font-medium text-gray-700">Blok</label>
                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_blok" placeholder="">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_rt"
                                                    class="block text-sm font-medium text-gray-700">RT</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    name="tb_rt" placeholder="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_rw"
                                                    class="block text-sm font-medium text-gray-700">RW</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    name="tb_rw" placeholder="">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_prov"
                                                    class="block text-sm font-medium text-gray-700">Provinsi</label>

                                                <input type="text" name="tb_prov" id="tb_prov"
                                                    class="border rounded-md py-2 px-3 w-full">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kota"
                                                    class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    name="tb_kota" placeholder="">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="mb-4">
                                                <label for="tb_kecamatan"
                                                    class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    name="tb_kecamatan" placeholder="">
                                            </div>
                                            <div class="mb-4">
                                                <label for="tb_kelurahan"
                                                    class="block text-sm font-medium text-gray-700">Kelurahan</label>
                                                <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                    name="tb_kelurahan" placeholder="">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="tb_kodepos" class="block text-sm font-medium text-gray-700">Kode
                                                Pos</label>

                                            <input type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_kodepos" placeholder="">
                                        </div>
                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Create
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
        var loadFile = function(event) {

            var input = event.target;
            var file = input.files[0];
            var type = file.type;

            var output = document.getElementById('preview_img');


            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
