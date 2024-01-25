@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <header class="bg-gray-200 p-4">
        <h2>
            Manage Stocks in
            @if (empty($currentEntity))
                Selindo
            @else
                {{-- @if ($isProvinsi)
                    {{ $currentEntity->provinsi }}
                @else --}}
                    {{ $currentEntity->nama_company }}
                {{-- @endif --}}
            @endif
        </h2>
    </header>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <div class="overflow-auto m-3">
        @if (!empty($currentEntity))
            @if (!$isProvinsi)
                <div
                    class="flex justify-between items-center w-100 p-2 rounded border border-opacity-30 border-slate-500 bg-blue-950 text-white">
                    <h1 class="font-medium">GUDANG IN {{ $currentEntity->nama_company }}</h1>
                    {{-- <form action="{{ route('stok.index') }}">
                        <input type="hidden" name="provinsi" value="{{ $currentEntity->provinsi }}">
                        <button type="submit" class="btn btn-sm btn-outline text-white">
                            Lihat
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </form> --}}
                </div>
            @endif
        @endif
        <table class="min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telp
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat
                    </th>
                    @if (!$isProvinsi)
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($gudang as $key => $gd)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $gd->nama_gudang_erp }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $gd->no_telp }}</td>
                        <td class="px-6 py-4 whitespace-normal">
                            <p class="line-clamp-1">
                                {{ $gd->jalan }},
                                {{ $gd->blok }},
                                RT {{ $gd->rt }},
                                RW {{ $gd->rw }},
                                {{ $gd->kelurahan }},
                                {{ $gd->kecamatan }},
                                {{ $gd->kota_kabupaten }},
                                {{ $gd->provinsi }}
                            </p>
                        </td>
                        @if (!$isProvinsi)
                            <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                <a href="{{ route('stok.show', ['id' => $gd->gid]) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection
