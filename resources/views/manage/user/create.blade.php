@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    @if (Session::has('message'))
        <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" role="alert" id="alertMessage">
            <p>{{ Session::get('message') }}.</p>
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
        <script>
            // After the page loads
            document.addEventListener('DOMContentLoaded', function() {
                var alert = document.getElementById('alertMessage');

                if (alert) {
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                }

                var closeButton = alert.querySelector('.close-button');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        alert.style.display = 'none';
                    });
                }
            });
        </script>
    @endif


    <div class="container overflow-scroll">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="bg-gray-100 py-2 px-4 font-semibold">New User</div>
                    <div class="p-4 w-full mx-3">
                        <form method="POST" action="{{ route('manage.user.store') }}">
                            <div class="flex w-full justify-between">
                                @csrf
                                <div class="w-full md:w-1/2">
                                    <div class="border border-gray-300 rounded p-4 mx-3">
                                        <h4 class="text-lg font-semibold">Account</h4>
                                        <hr class="my-4">

                                        <div class="mb-4">
                                            <label for="tb_nama_user"
                                                class="block text-sm font-medium text-gray-700">Role</label>
                                            <select class="border rounded-md py-2 px-3 w-full" name="cb_role"
                                                id="cb_role">
                                                @forelse ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                                @empty
                                                    <option value="">Role Kosong</option>
                                                @endforelse
                                            </select>
                                        </div>

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

                                        <div class="mb-4">
                                            <label for="tb_external_id" class="block text-sm font-medium text-gray-700">ID External</label>
                                            <input required id="tb_external_id" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_external_id" placeholder="">
                                            @error('tb_external_id')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200">
                                            Submit
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
