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
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between">
            <h2>
                Manage Banner
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('banner.create') }}">
                    <i class="fa-solid fa-add"></i>
                    New Banner
                </a>
            </div>
        </div>
    </header>

    @include('layouts.alert-popup')

    @include('layouts.searchbar', [
        'routeName' => 'banner.index',
        'placeholder' => 'Masukkan judul banner, contoh: Promo 6.6',
    ])

    <div class="overflow-auto m-3">
        <table id="myTable" class="min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($banners as $banner)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . $banner->gambar_banner) }}" alt="gambar" class="w-20 h-20">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $banner->judul_banner }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $banner->deskripsi_banner }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
                            <div class="flex items-center">
                                <div class="dropdown dropdown-bottom dropdown-end mx-1">
                                    <div tabindex="0" role="button" class="btn btn-sm m-1">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a href="{{ route('banner.show', ['id' => $banner->id]) }}">
                                                {{-- <svg class="showIcon"> </svg> --}}
                                                <i class="fa-solid fa-bars"></i>
                                                Lihat detail
                                            </a></li>
                                        <li><a href="{{ route('banner.delete', ['id' => $banner->id]) }}"
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
        {{ $banners->links('pagination::tailwind') }}
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
