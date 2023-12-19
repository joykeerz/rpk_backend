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
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Company (Entitas)') }}
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('company.create') }}">
                    <i class="fa-solid fa-add"></i>
                    New Company
                </a>
            </div>
        </div>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar')

    <div class="overflow-y-auto m-3">
        <table id="myTable" class="table table-sm table-zebra hover">
            <thead class="border border-b-1">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Kantor</th>
                    <th class="px-4 py-2">Nama Kantor</th>
                    <th class="px-4 py-2">PIC</th>
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
                                class="btn btn-sm btn-primary mr-1">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('company.delete', ['id' => $item->cid]) }}" onclick="return confirmDelete()"
                                class="btn btn-sm btn-error text-white">
                                <i class="fa-solid fa-trash"></i>
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
