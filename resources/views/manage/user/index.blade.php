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
    @include('layouts.searchbar')

    <div class="table-responsive mx-3">
        <table id="myTable" class="table table-zebra hover">
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
                    <tr>
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
                                    class="btn btn-sm primary mr-1">
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
