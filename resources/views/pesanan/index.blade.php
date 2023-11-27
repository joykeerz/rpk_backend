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

    @include('layouts.searchbar')
    @include('layouts.alert')

    <div class="tableContainer m-3">
        <table class="w-full text-center overflow-y-auto border mb-4    ">
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
            <tbody>
                @forelse ($transaksi as $item)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class=" px-4 py-2">K{{ $item->tid }}</td>
                        <td class=" px-4 py-2">{{ $item->name }}</td>
                        <td class=" px-4 py-2">{{ $item->status_pembayaran }}</td>
                        <td class=" px-4 py-2">{{ $item->status_pemesanan }}</td>
                        <td class="subtotal_produk px-4 py-2">Rp {{ number_format($item->subtotal_produk) }}</td>
                        <td>
                            <a class="" href="{{ route('pesanan.show', ['id' => $item->tid]) }}">open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transaksi->links('pagination::tailwind') }}
    </div>
    {{-- <script>
        const subtotal_produk = document.querySelectorAll('.subtotal_produk');

        subtotal_produk.forEach((item) => {
            item.innerHTML = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(item.innerHTML);
        });
    </script> --}}
@endsection
