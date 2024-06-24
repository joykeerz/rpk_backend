@extends('layouts.bar')

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection

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
                {{ __('Manage Product') }}
            </h2>
            <div class="flex items-center">
                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                        Sync Products
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('odoo.product.import') }}">Import Product ERP</a></li>
                        <li><a>Export Product RPK</a></li>
                        <li><a>Sync All</a></li>
                    </ul>
                </div>
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="{{ route('product.index') }}">
                        <i class="fa-solid fa-add"></i>
                        New Product
                    </a>
                </div>
            </div>
        </div>
    </header>

    @include('layouts.alert-popup')

    @include('layouts.searchbar', [
        'routeName' => 'product.manage',
        'placeholder' => 'Masukkan nama produk, contoh: Beras Alhambra',
    ])
    <div class="overflow-auto m-3">
        <table id="myTable" class="table table-sm table-zebra">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                    </th>
                    <th scope="col">
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $pd)
                    <tr class="hover">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $products->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $pd->produk_file_path) }}" alt="gambar" class="w-20 h-20">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap w-full">
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('product.show', ['id' => $pd->pid]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a></li>
                                        <li><a href="{{ route('product.delete', ['id' => $pd->pid]) }}"
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
