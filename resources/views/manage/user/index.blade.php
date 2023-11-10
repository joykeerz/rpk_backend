@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    <header>
        <div class="title flex m-5 justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage User') }}
            </h2>

            <div class="button">
                <a class="btn btn-primary align-center w-full border border-black p-2 rounded hover:bg-gray-800 hover:text-white duration-200"
                    href="{{ route('manage.user.new') }}">New User</a>
            </div>
        </div>
    </header>
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


    <div class="table-responsive mx-3">
        <table class="min-w-full divide-y divide-gray-200 text-center">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No.Hp</th>
                    <th scope="col">Status</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usersData as $ud)
                    <tr class="hover:bg-gray-50">
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $ud->id }}</td>
                        <td>{{ $ud->name }}</td>
                        <td>{{ $ud->email }}</td>
                        <td>{{ $ud->no_hp }}</td>
                        <td>
                            @switch($ud->isVerified)
                                @case(0)
                                    Belum Terverifikasi
                                @break

                                @case(1)
                                    Terverifikasi
                                @break

                                @case(2)
                                    Rejected
                                @break
                            @endswitch
                        </td>
                        <td>{{ $ud->nama_role }}</td>
                        <td class="flex justify-evenly p-2">
                            <a href="{{ route('manage.user.verify', ['id' => $ud->uid]) }}"
                                class="bg-gray-300 text-gray-700 py-1 px-3 rounded-lg hover:bg-green-500 hover:text-white duration-200">Verify
                            </a>

                            <a href="{{ route('manage.user.reject', ['id' => $ud->uid]) }}"
                                class="bg-gray-300 text-gray-700 py-1 px-3 rounded-lg hover:bg-red-500 hover:text-white duration-200">Reject
                            </a>

                            <a href="{{ route('manage.user.edit', ['id' => $ud->uid]) }}"
                                class="bg-blue-500 text-white py-1 px-3 rounded-lg">Manage
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    @endsection
