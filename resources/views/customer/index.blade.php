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
    <header class="bg-gray-200 p-3">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Customer') }}
                @if (empty($currentEntity))
                    Selindo
                @else
                    @if ($isProvinsi)
                        {{ $currentEntity->provinsi }}
                    @else
                        {{ $currentEntity->kota_kabupaten }}
                    @endif
                @endif
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('customer.create') }}">
                    <i class="fa-solid fa-add"></i>
                    New Customer
                </a>
            </div>
        </div>
    </header>

    @include('layouts.searchbar')
    <div class="table-responsive m-3">
        @if (!empty($currentEntity))
            @if (!$isProvinsi)
                <div
                    class="flex justify-between items-center w-full p-2 rounded border border-opacity-30 border-slate-500 bg-blue-950 text-white">
                    <h1 class="font-medium">CUSTOMER SE-{{ $currentEntity->provinsi }}</h1>
                    <form action="{{ route('customer.index') }}">
                        <input type="hidden" name="provinsi" value="{{ $currentEntity->provinsi }}">
                        <button type="submit" class="btn btn-sm btn-outline text-white">
                            Lihat
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </form>
                </div>
            @endif
        @endif
        <table id="myTable" class="min-w-full divide-y divide-gray-200 text-center">
            <thead class="text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nama RPK</th>
                    <th scope="col">Email</th>
                    <th scope="col">No.Hp</th>
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
                        @if (!$isProvinsi)
                            <td class="flex justify-evenly p-2">
                                <a href="{{ route('customer.show', ['id' => $ud->bid]) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('customer.delete', ['id' => $ud->bid]) }}" class="btn btn-sm btn-error"
                                    onclick="return deleteConfirmation()">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </a>
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
