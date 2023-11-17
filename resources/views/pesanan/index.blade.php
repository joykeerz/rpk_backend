@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    <header class=" bg-gray-200 p-4">
        <div class="title justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaksi') }}
            </h2>
        </div>
    </header>


    <div class="tableContainer m-3">
        <table class="w-full text-center overflow-y-auto border">
            <thead class="text-center border-b-1 border">
                <tr>
                    <th class="px-4 py-2">Kode Transaksi</th>
                    <th class="px-4 py-2">Nama Pemesan</th>
                    <th class="px-4 py-2">Status Pembayaran</th>
                    <th class="px-4 py-2">Status Pemesanan</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Detail Pesanan</th>
                </tr>
            </thead>
            @forelse ($transaksi as $item)
                <tbody>
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white'}} ">
                        <td class=" px-4 py-2">{{ $item->tid }}</td>
                        <td class=" px-4 py-2">{{ $item->name }}</td>
                        <td class=" px-4 py-2">{{ $item->status_pembayaran }}</td>
                        <td class=" px-4 py-2">{{ $item->status_pemesanan }}</td>
                        <td class="subtotal_produk px-4 py-2">{{ $item->subtotal_produk }}</td>
                        <td>
                            <a class="" href="{{ route('pesanan.show', ['id' => $item->tid]) }}">open</a>
                        </td>
                    </tr>
                </tbody>
            @empty
                <h1>tidak ada data yang tersedia</h1>
            @endforelse
        </table>

    </div>





    <script>
        const subtotal_produk = document.querySelectorAll('.subtotal_produk');

        subtotal_produk.forEach((item) => {
            item.innerHTML = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(item.innerHTML);
        });
    </script>
@endsection
