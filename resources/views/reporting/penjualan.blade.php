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
            Penjualan Reporting
        </h2>
    </header>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>

    <div class="overflow-auto m-3">
        <div class="w-fit flex flex-row align-middle justify-between bg-gray-100 px-2 py-2 rounded-md">
            <form action="{{ route('laporan.penjualan.export') }}" method="get">
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
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Customer
                    </th>
                    <th scope="col" class="text-gray-500 uppercase tracking-wider">Tipe Pembayaran
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Status Pembayaran
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Status Pemesanan
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Subtotal
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Biaya Kirim
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Qty
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Total
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Tgl. Transaksi
                    </th>
                    <th scope="col" class=" text-gray-500 uppercase tracking-wider">Metode Kirim
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $trans)
                    <tr>
                        <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap">{{ $trans->name }}</td>
                        <td class="whitespace-nowrap">{{ $trans->tipe_pembayaran }}</td>
                        <td class="whitespace-nowrap">{{ $trans->status_pembayaran }}</td>
                        <td class="whitespace-nowrap">{{ $trans->status_pemesanan }}</td>
                        <td class="whitespace-nowrap">{{ 'Rp ' . number_format($trans->subtotal_produk, 2) }}</td>
                        <td class="whitespace-nowrap">{{ 'Rp ' . number_format($trans->subtotal_pengiriman, 2) }}</td>
                        <td class="whitespace-nowrap">{{ 'Rp ' . number_format($trans->total_qty, 2) }}</td>
                        <td class="whitespace-nowrap">{{ 'Rp ' . number_format($trans->total_pembayaran, 2) }}</td>
                        <td class="whitespace-nowrap">{{ $trans->cat }}</td>
                        <td class="whitespace-nowrap">{{ $trans->nama_kurir }}</td>
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
