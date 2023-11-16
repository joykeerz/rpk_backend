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
            <form action="{{ route('laporan.penjualan.export') }}" method="get">
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
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pemesanan
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Transaksi
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Kirim
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $trans)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->tipe_pembayaran }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->status_pembayaran }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->status_pemesanan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ 'IDR ' . number_format($trans->subtotal_produk, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->cat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trans->nama_kurir }}</td>
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
        .bege-white {
            background-color: white;
            border: 1px solid black;
        }

        .bege-white:hover {
            background-color: black;
            color: white;
        }
    </style>
@endsection
