@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
    <header class="bg-gray-200 p-4">
        <h2>
            Manage Banner
        </h2>
    </header>

    @include('layouts.alert')
    @include('layouts.searchbar')

    <div class="overflow-auto m-3">
        <table class="min-w-full bg-white text-center">
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
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                            <a href="{{ route('banner.show', ['id' => $banner->id]) }}"
                                class="m-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                <svg class="showIcon"> </svg>
                            </a>
                            <a href="{{ route('banner.delete', ['id' => $banner->id]) }}" onclick="return confirmDelete();"
                                class="m-2 bg-red-500 text-white rounded-md px-3 py-1 flex items-center justify-center">
                                <svg class="deleteIcon"></svg>
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
        {{ $banners->links('pagination::tailwind') }}
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection
