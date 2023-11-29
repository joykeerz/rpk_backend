@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
@endsection

@section('content')
    <header class="bg-gray-200 py-1">
        <div class="title flex m-5 justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage User') }}
            </h2>
            @if (Auth::user()->role_id != 3)
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('manage.user.new') }}">
                        <i class="fa-solid fa-add"></i>
                        New User
                    </a>
                </div>
            @endif
        </div>
    </header>
    @include('layouts.alert')

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
            $(document).ready(function() {
                $('#searchInput').on('input', function() {
                    var searchValue = $(this).val().toLowerCase();
                    $('tbody tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                        if ($(this).text().toLowerCase().indexOf(searchValue) > -1) {
                            $(this).removeClass('bg-gray-100');
                        } else {
                            $(this).addClass('bg-white');
                        }
                    });
                });
            });
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

    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var searchValue = $(this).val().toLowerCase();
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                    if ($(this).text().toLowerCase().indexOf(searchValue) > -1) {
                        $(this).removeClass('bg-gray-100');
                    } else {
                        $(this).addClass('bg-white');
                    }
                });
            });
        });
    </script>

    <div class="searchBar flex justify-center m-3">
        <input type="text" id="searchInput"
            class="rounded-md border-gray border shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2 w-1/4"
            placeholder="Search...">
    </div>


    <div class="table-responsive mx-3">
        <table id="myTable" class="min-w-full divide-y divide-gray-200 text-center">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No.Hp</th>
                    <th scope="col">Status</th>
                    <th scope="col">Role</th>
                    @if (Auth::user()->role_id != 3)
                        <th scope="col">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($usersData as $ud)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        {{-- <td>{{ $loop->iteration }}</td> --}}
                        <td>{{ $loop->iteration }}</td>
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
                        @if (Auth::user()->role_id != 3)
                            <td class="flex justify-evenly p-2">
                                <a href="{{ route('manage.user.verify', ['id' => $ud->uid]) }}"
                                    class="btn btn-sm btn primary mr-1">
                                    <i class="fa-solid fa-check"></i>
                                    Verify
                                </a>

                                <a href="{{ route('manage.user.reject', ['id' => $ud->uid]) }}"
                                    class="btn btn-sm btn-outline mr-1">
                                    <i class="fa-solid fa-xmark"></i>
                                    Reject
                                </a>

                                <a href="{{ route('manage.user.edit', ['id' => $ud->uid]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            {{ $usersData->links('pagination::tailwind') }}

        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    responsive: true,
                    searching: false,
                    ordering: true,
                    paging: false,
                    info: false,
                });
            });
        </script>
    @endsection
