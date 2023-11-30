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
            return confirm("Are you sure you want to delete this company?");
        }
    </script>
    <header class="bg-gray-200 p-3">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kantor Wilayah (Company)') }}
        </h2>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar')

    <div class="overflow-y-auto m-3">
        <table id="myTable" class="min-w-full table-auto border ">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Kantor</th>
                    <th class="px-4 py-2">Nama Kantor</th>
                    <th class="px-4 py-2">Partner</th>
                    <th class="px-4 py-2">Tagline</th>
                    <th class="px-4 py-2">Provinsi</th>
                    <th class="px-4 py-2">Detail</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($companies as $item)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}  ">
                        <td class=" px-4 py-2">{{ $loop->iteration }}</td>
                        <td class=" px-4 py-2">{{ $item->kode_company }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                        <td class=" px-4 py-2">{{ $item->partner_company }}</td>
                        <td class=" px-4 py-2">{{ $item->tagline_company }}</td>
                        <td class=" px-4 py-2">{{ $item->provinsi }}</td>
                        <td class=" px-4 py-2 flex justify-center">
                            <a href="{{ route('company.show', ['id' => $item->cid]) }}"
                                class="bg-blue-500 m-3 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                <svg class="showIcon"> </svg>
                            </a>
                            <a href="{{ route('company.delete', ['id' => $item->cid]) }}" onclick="return confirmDelete()"
                                class="bg-red-500 m-3 hover:bg-red-700 text-white py-1 px-2 rounded">
                                <svg class="deleteIcon"></svg></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border text-center py-4">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $companies->links('pagination::tailwind') }}

    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
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
