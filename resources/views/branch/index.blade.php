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
            <h2 class="">
                {{ __('Branch (Kancab)') }}
            </h2>
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Branch
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.branch.import') }}">Import Branch</a></li>
                        <li><a>Export Branch RPK</a></li>
                        <li><a>Sync All</a></li>
                    </ul>
                </div>

                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('branch.create') }}">
                        <i class="fa-solid fa-add"></i>
                        New Branch
                    </a>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.alert-popup')

    @include('layouts.searchbar', [
        'routeName' => 'branch.index',
        'placeholder' => 'Masukkan nama branch, contoh: DKI Jakarta',
    ])

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this branch?");
        }
    </script>
    <div class="overflow-y-auto m-3">
        <table id="myTable" class="table table-sm table-zebra">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Branch</th>
                    <th class="px-4 py-2">Company</th>
                    <th class="px-4 py-2">No Telp</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($branch as $item)
                    <tr class="hover">
                        <td class=" px-4 py-2">{{ $branch->firstItem() + $loop->index }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_branch }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                        <td class=" px-4 py-2">{{ $item->no_telp_branch }}</td>
                        <td class=" px-4 py-2">{{ $item->alamat_branch }}</td>
                        <td class=" px-4 py-2 flex justify-center">
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('branch.show', ['id' => $item->bid]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a></li>
                                        <li><a href="{{ route('branch.delete', ['id' => $item->bid]) }}"
                                                onclick="return confirmDelete();" class="text-red-600">
                                                {{-- <svg class="deleteIcon"></svg> --}}
                                                <i class="fa-solid fa-trash"></i>
                                                Hapus produk

                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No data available</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $branch->links('pagination::tailwind') }}
        <link rel="stylesheet" href="{{ asset('svg.css') }}">
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
