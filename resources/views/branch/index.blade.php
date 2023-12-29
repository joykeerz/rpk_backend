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
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kantor Cabang (Branch)') }}
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('branch.create') }}">
                    <i class="fa-solid fa-add"></i>
                    New Branch
                </a>
            </div>
        </div>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar', ['routeName' => 'branch.index'])

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this branch?");
        }
    </script>
    <div class="overflow-y-auto m-3">
        <table id="myTable" class="min-w-full table-auto border ">
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
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class=" px-4 py-2">{{ $loop->iteration }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_branch }}</td>
                        <td class=" px-4 py-2">{{ $item->nama_company }}</td>
                        <td class=" px-4 py-2">{{ $item->no_telp_branch }}</td>
                        <td class=" px-4 py-2">{{ $item->alamat_branch }}</td>
                        <td class=" px-4 py-2 flex justify-center">
                            <a href="{{ route('branch.show', ['id' => $item->bid]) }}" class="btn btn-sm btn-primary mr-1">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('branch.delete', ['id' => $item->bid]) }}" onclick="return confirmDelete();"
                                class="btn btn-sm btn-error text-white">
                                <i class="fa-solid fa-trash"></i>
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
