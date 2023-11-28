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
        <div class="w-fit flex flex-row align-middle justify-between bg-gray-100 px-2 py-2 rounded-md">
            <form action="{{ route('laporan.stok.export') }}" method="get">
                @csrf
                From:
                <input class="border border-gray-400 rounded px-2 py-1" type="date" name="from" id="from">
                To:
                <input class="border border-gray-400 rounded px-2 py-1" type="date" name="to" id="to">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>
            </form>


        </div>

        <table class="table table-sm">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Kode
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Produk
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Kategori
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Harga
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Stok
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Satuan
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Gudang
                    </th>
                    <th scope="col" class="text-xs text-gray-500 uppercase tracking-wider">Diskon
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap">{{ $stock->kode_produk }}</td>
                        <td class="whitespace-nowrap">{{ $stock->nama_produk }}</td>
                        <td class="whitespace-nowrap">{{ $stock->nama_kategori }}</td>
                        <td class="whitespace-nowrap">{{ 'Rp ' . number_format($stock->harga_stok, 2) }}</td>
                        <td class="whitespace-nowrap">{{ $stock->jumlah_stok }}</td>
                        <td class="whitespace-nowrap">{{ $stock->simbol_satuan }}</td>
                        <td class="whitespace-nowrap">{{ $stock->nama_gudang }}</td>
                        <td class="whitespace-normal">{{$stock->diskon_produk}}%</td>
                        {{-- <td class="whitespace-normal">
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
                        </td> --}}
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
