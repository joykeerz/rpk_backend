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
            return confirm("Are you sure you want to delete this address?");
        }
    </script>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
    <header class="bg-gray-200 p-3">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Alamat
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('daftar-alamat.customer.create', ['id' => $userID]) }}">
                    <i class="fa-solid fa-add"></i>
                    Tambah Alamat
                </a>
            </div>
        </div>
    </header>
    @include('layouts.alert')
    {{-- @include('layouts.searchbar') --}}
    <div class="table-responsive m-3">
        <table id="myTable" class="table table-sm table-zebra hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Provinsi</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alamatList as $item=>$alamat)
                    <tr class="hover:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td class="truncate">{{ $alamat->jalan }}, {{ $alamat->jalan_ext }}, {{ $alamat->blok }}</td>
                        <td>{{ $alamat->provinsi }}</td>
                        <td>{{ $alamat->kota_kabupaten }}</td>
                        <td>
                            @if ($alamat->isActive)
                                Aktif
                            @else
                                Non-Aktif
                            @endif
                        </td>
                        <td class="grid grid-cols-2 gap-2">
                            @if (!$alamat->isActive)
                                <a href="{{ route('daftar-alamat.customer.toggle', ['id' => $alamat->alamat_id]) }}"
                                    class="btn btn-sm btn-outline">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                            @endif

                            <a href="{{ route('daftar-alamat.customer.show', ['id' => $alamat->alamat_id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('daftar-alamat.customer.delete', ['id' => $alamat->alamat_id]) }}"
                                class="btn btn-sm btn-error" onclick="return deleteConfirmation()">
                                <i class="fa-solid fa-trash text-white"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{ $alamatList->links('pagination::tailwind') }}

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
