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
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2>
                {{ __('Manage User') }}
            </h2>
            <div class="flex items-center">
                @if (Auth::user()->role_id != 4 || Auth::user()->role_id != 5)
                    <div class="dropdown dropdown-bottom dropdown-end mx-1">
                        <div tabindex="0" role="button" class="btn btn-sm m-1">
                            Sync Users
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a href="{{ route('odoo.user.import.manager-sales') }}">Import Manager Sales</a></li>
                            <li><a>Export User RPK</a></li>
                            <li><a>Sync All</a></li>
                        </ul>
                    </div>
                    <div class="button">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.user.new') }}">
                            <i class="fa-solid fa-add"></i>
                            New User
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar', ['routeName' => 'manage.user.index'])

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
                        <td>{{ $usersData->firstItem() + $loop->index }}</td>
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
                            <td class="flex justify-evenly items-center p-2">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li>
                                            <a href="{{ route('manage.user.edit', ['id' => $ud->uid]) }}">
                                                <i class="fa-solid fa-eye"></i>
                                                Detail
                                            </a>
                                        </li>
                                        @if ($ud->isVerified == 0)
                                            <li>
                                                <a href="{{ route('manage.user.verify', ['id' => $ud->uid]) }}">
                                                    <i class="fa-solid fa-check"></i>
                                                    Verify
                                                </a>

                                            </li>
                                            <li>
                                                <a href="{{ route('manage.user.reject', ['id' => $ud->uid]) }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    Reject
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
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
