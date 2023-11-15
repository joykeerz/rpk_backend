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
            Stok Reporting
        </h2>
    </header>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <div class="overflow-auto m-3">
        <input type="text" id="searchInput"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Search...">

        <div class="flex flex-row align-middle justify-between bg-gray-100 px-2 py-1 rounded-md">
            <form action="{{ route('laporan.stok.export') }}" method="get">
                @csrf
                From:
                <input class="border border-gray-400 rounded px-2 py-1" type="date" name="from" id="from">
                To:
                <input class="border border-gray-400 rounded px-2 py-1" type="date" name="to" id="to">
                <button type="submit" class="bege-white text-black font-bold py-1 px-2 rounded">
                    Filter
                </button>
            </form>


        </div>

        <table class="min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gudang
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->kode_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ 'IDR ' . number_format($stock->harga_produk, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->jumlah_stok }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_gudang }}</td>
                        <td class="px-6 py-4 whitespace-normal">
                            <p class="line-clamp-1">
                                {{ $stock->jalan }},
                                {{ $stock->blok }},
                                RT {{ $stock->rt }},
                                RW {{ $stock->rw }},
                                {{ $stock->kelurahan }},
                                {{ $stock->kecamatan }},
                                {{ $stock->kota_kabupaten }},
                                {{ $stock->provinsi }}
                            </p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
    <style>
        .bege-white{
            background-color: white;
            border: 1px solid black;
        }

        .bege-white:hover{
            background-color: black;
            color: white;
        }
    </style>
@endsection
