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

                // Optionally, you might want to add functionality to close the alert with the close button
                var closeButton = alert.querySelector('.close-button');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        alert.style.display = 'none';
                    });
                }
            });
        </script>
    @endif


    <div class="container">
        <div class="flex flex-col w-full">
            <div class="w-full ">
                <div class="bg-white">
                    <div class="bg-gray-100 py-2 px-4 font-semibold">User Detail</div>
                    <div class="p-4 w-full mx-3">
                        <div class="flex w-full justify-between">
                            <div class="w-full md:w-1/2">
                                <div class="border border-gray-300 rounded p-4 mx-3">
                                    <h4 class="text-lg font-semibold">Account</h4>
                                    <hr class="my-4">
                                    <form method="POST"
                                        action="{{ route('manage.user.update', ['id' => $userData->id]) }}">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="cb_role"
                                                class="block text-sm font-medium text-gray-700">Role</label>
                                            <select class="border rounded-md py-2 px-3 w-full" name="cb_role"
                                                id="cb_role">
                                                @forelse ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        @if ($role->id == $userData->role_id) selected @endif>
                                                        {{ $role->nama_role }}</option>
                                                @empty
                                                    <option value="">Role Kosong</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="cb_company"
                                                class="block text-sm font-medium text-gray-700">Company/Entitas</label>
                                            <select class="border rounded-md py-2 px-3 w-full" name="cb_company"
                                                id="cb_company">
                                                @forelse ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        @if ($company->id == $userData->company_id) selected @endif>
                                                        {{ $company->nama_company }}</option>
                                                @empty
                                                    <option value="">Role Kosong</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_nama_user"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input required id="tb_nama_user" value="{{ $userData->name }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_nama_user"
                                                placeholder="">
                                            @error('tb_nama_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_email_user"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input required id="tb_email_user" value="{{ $userData->email }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_email_user"
                                                placeholder="">
                                            @error('tb_email_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_hp_user" class="block text-sm font-medium text-gray-700">No.
                                                Handphone</label>
                                            <input required id="tb_hp_user" value="{{ $userData->no_hp }}" type="text"
                                                class="border rounded-md py-2 px-3 w-full" name="tb_hp_user" placeholder="">
                                            @error('tb_hp_user')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="tb_external_id" class="block text-sm font-medium text-gray-700">ID
                                                External</label>
                                            <input id="tb_external_id" value="{{ $userData->external_user_id }}"
                                                type="text" class="border rounded-md py-2 px-3 w-full"
                                                name="tb_external_id" placeholder="">
                                            @error('tb_external_id')
                                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>


                                        <button type="submit"
                                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update
                                        </button>
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
                                            <input type="password" class="border rounded-md py-2 px-3 w-full"
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
