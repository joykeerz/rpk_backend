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
        <div class="flex justify-between">
            <h2>
                Manage Product
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('product.index') }}">
                    <i class="fa-solid fa-add"></i>
                    New Product
                </a>
            </div>
        </div>
    </header>

    @include('layouts.alert')

    @include('layouts.searchbar')
    <div class="overflow-auto m-3">
        <table id="myTable" class="min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $pd)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $pd->produk_file_path) }}" alt="gambar" class="w-20 h-20">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                            <a href="{{ route('product.show', ['id' => $pd->pid]) }}" class="btn btn-sm btn-primary mr-1">
                                {{-- <svg class="showIcon"> </svg> --}}
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('product.delete', ['id' => $pd->pid]) }}" onclick="return confirmDelete();"
                                class="btn btn-sm btn-error">
                                {{-- <svg class="deleteIcon"></svg> --}}
                                <i class="fa-solid fa-trash text-white"></i>

                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $products->links('pagination::tailwind') }}

    </div>

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
