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
    <header class="bg-gray-200 p-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Home > {{ __('Satuan Unit') }}
        </h2>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar')

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this data?");
        }
    </script>
    <div class="overflow-y-auto m-3">
        <table id="myTable" class="min-w-full table-auto border ">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Satuan</th>
                    <th class="px-4 py-2">Simbol Satuan</th>
                    <th class="px-4 py-2">Keterangan</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($satuanUnit as $st)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $st->nama_satuan }}</td>
                        <td class="px-4 py-2">{{ $st->satuan_unit_produk }}</td>
                        <td class="px-4 py-2">{{ $st->keterangan }}</td>
                        <td class="px-4 py-2 flex justify-center">
                            <a href="{{ route('satuan-unit.show', ['id' => $st->id]) }}"
                                class="m-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                <svg class="showIcon"> </svg>
                            </a>
                            <a href="{{ route('satuan-unit.delete', ['id' => $st->id]) }}" onclick="return confirmDelete();"
                                class="m-2 bg-red-500 text-white rounded-md px-3 py-1 flex items-center justify-center">
                                <svg class="deleteIcon"></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No data available</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $satuanUnit->links('pagination::tailwind') }}
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
