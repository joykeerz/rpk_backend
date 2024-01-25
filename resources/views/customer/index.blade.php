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
    <script>
        function deleteConfirmation() {
            return confirm("Are you sure you want to delete this customer?");
        }
    </script>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2>
                {{ __('Manage Customer in') }}
                @if (empty($currentEntity))
                    Selindo
                @else
                    {{-- @if ($isProvinsi)
                        {{ $currentEntity->provinsi }}
                    @else
                        {{ $currentEntity->kota_kabupaten }}
                    @endif --}}
                    {{ $currentEntity->nama_company }}
                @endif
            </h2>
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Customer
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.user.import.partner') }}">Import Customer</a></li>
                        <li><a>Export Customer RPK</a></li>
                        <li><a>Sync All</a></li>
                    </ul>
                </div>
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('customer.create') }}">
                        <i class="fa-solid fa-add"></i>
                        New Customer
                    </a>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar', ['routeName' => 'customer.index'])

    <div class="table-responsive m-3">
        @if (!empty($currentEntity))
            @if (!$isProvinsi)
                <div
                    class="flex justify-between items-center w-full p-2 rounded border border-opacity-30 border-slate-500 bg-blue-950 text-white">
                    <h1 class="font-medium">Customers in {{ $currentEntity->nama_company }}</h1>
                    {{-- <form action="{{ route('customer.index') }}">
                        <input type="hidden" name="provinsi" value="{{ $currentEntity->provinsi }}">
                        <button type="submit" class="btn btn-sm btn-outline text-white">
                            Lihat
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </form> --}}
                </div>
            @endif
        @endif
        <table id="myTable" class="table table-sm table-zebra hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nama RPK</th>
                    <th scope="col">Email</th>
                    <th scope="col">No.Hp</th>
                    <th scope="col">Status</th>
                    @if (!$isProvinsi)
                        <th scope="col">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($customer as $item=>$ud)
                    <tr class="hover:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ud->name }}</td>
                        <td>
                            <span class="truncate">
                                {{ $ud->nama_rpk }}
                            </span>
                        </td>
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
                        @if (!$isProvinsi)
                            <td class="grid grid-cols-2 gap-2 items-center">
                                <a href="{{ route('customer.show', ['id' => $ud->bid]) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        @if ($ud->isVerified == 0)
                                            <li><a href="{{ route('customer.verify', ['id' => $ud->uid]) }}">
                                                    <i class="fa-solid fa-check"></i>Verify
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('customer.reject', ['id' => $ud->uid]) }}">
                                                    <i class="fa-solid fa-xmark"></i>Reject
                                                </a>
                                            </li>
                                        @endif
                                        <hr class="my-2 border-gray-200">
                                        <li>
                                            <a href="{{ route('customer.delete', ['id' => $ud->bid]) }}"
                                                class="btn btn-sm btn-error" onclick="return deleteConfirmation()">
                                                <i class="fa-solid fa-trash text-white"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{ $customer->links('pagination::tailwind') }}

        </div>

        <style>
            td {
                text-overflow: ellipsis;
            }
        </style>
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
