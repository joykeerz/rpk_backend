@extends('layouts.bar')
@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection


@section('content')
@if (Session::has('message'))
    <div class="bg-blue-200 border border-blue-400 text-blue-800 py-2 px-4 mb-4 rounded" role="alert">
        <p>{{ Session::get('message') }}.</p>
    </div>
@endif

<div class="container">
    <div class="flex flex-col w-full">
        <div class="w-full ">
            <div class="bg-white rounded-lg shadow-md">
                <div class="bg-gray-100 py-2 px-4 font-semibold">User Detail</div>
                <div class="p-4 w-full mx-3">
                    <div class="flex w-full justify-between">
                        <div class="w-full md:w-1/2">
                            <div class="border border-gray-300 rounded p-4 mx-3">
                                <h4 class="text-lg font-semibold">Account</h4>
                                <hr class="my-4">
                                <form method="POST" action="{{ route('manage.user.update', ['id' => $userData->id]) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="tb_nama_user" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input required id="tb_nama_user" value="{{ $userData->name }}" type="text"
                                            class="border rounded-md py-2 px-3 w-full" name="tb_nama_user" placeholder="">
                                        @error('tb_nama_user')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="tb_email_user"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input required id="tb_email_user" value="{{ $userData->email }}" type="text"
                                            class="border rounded-md py-2 px-3 w-full" name="tb_email_user" placeholder="">
                                        @error('tb_email_user')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="tb_hp_user" class="block text-sm font-medium text-gray-700">No. Handphone</label>
                                        <input required id="tb_hp_user" value="{{ $userData->no_hp }}" type="text"
                                            class="border rounded-md py-2 px-3 w-full" name="tb_hp_user" placeholder="">
                                        @error('tb_hp_user')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @empty(!$userProfile)
                                             <div>
                                                 Biodata belum terisi
                                             </div>
                                             @endempty
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update</button>
                                </form>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2">
                            <div class="border border-gray-300 rounded p-4 mx-3">
                                <h4 class="text-lg font-semibold">Reset Password</h4>
                                <hr class="my-4">
                                <form method="POST"
                                    action="{{ route('manage.user.changePassword', ['id' => $userData->id]) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="tb_password_user"
                                            class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password"
                                            class="border rounded-md py-2 px-3 w-full"
                                            name="tb_password_user" placeholder="Masukan password baru...">
                                    </div>
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Change</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
