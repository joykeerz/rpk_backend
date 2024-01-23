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
        function confirmDelete() {
            return confirm("Are you sure you want to delete this gudang?");
        }
    </script>

    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2 class="">
                {{ __('Gudang') }}
            </h2>
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Gudang
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.gudang.import') }}">Import Gudang</a></li>
                        <li><a>Export Gudang RPK</a></li>
                        <li><a>Sync All</a></li>
                    </ul>
                </div>
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('gudang.create') }}">
                        <i class="fa-solid fa-add"></i>
                        New Gudang
                    </a>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar', ['routeName' => 'gudang.index'])
    <div class="overflow-y-auto m-3">
        <table id="myTable" class="min-w-full table-auto border">
            <thead class="border text-center">
                <tr class="">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama Gudang</th>
                    <th class="p-3">Alamat</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($gudangData as $gudang)
                    <tr class="border {{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $gudang->nama_gudang }}</td>
                        <td class="p-3">
                            Provinsi: {{ $gudang->provinsi }}
                            <br>
                            Kota: {{ $gudang->kota_kabupaten }}
                        </td>
                        <td class="p-3 flex justify-center">
                            <a href="{{ route('gudang.show', ['id' => $gudang->gid]) }}"
                                class="btn btn-sm btn-primary mr-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('gudang.delete', ['id' => $gudang->gid]) }}"
                                onclick="return confirmDelete();" class="btn btn-sm btn-error text-white">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{ $gudangData->links('pagination::tailwind') }}

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection

@section('script')
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
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
