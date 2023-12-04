@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    <header class=" bg-gray-200 p-4">
        <div class="title flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pesanan {{ $transaksi->name }}
            </h2>
            <div class="button">
                <a class="btn btn-sm btn-primary" href="{{ route('pesanan.edit', ['id' => $transaksi->tid]) }}">
                    <i class="fa-solid fa-pencil"></i>
                    Edit
                </a>
            </div>
        </div>
    </header>

    <div class="container columns-2 m-3">
        <div class="p-3 max-w-lg mx-auto bg-white border rounded-md overflow-scroll shadow-md">
            <table class="table table-xs table-zebra hover">
                <thead>
                    <tr>
                        <th class="pb-2 border-b border-gray-500">#</th>
                        <th class="pb-2 border-b border-gray-500">Produk</th>
                        <th class="pb-2 border-b border-gray-500">Jumlah</th>
                        <th class="pb-2 border-b border-gray-500">Harga</th>
                        <th class="pb-2 border-b border-gray-500">Pajak</th>
                        <th class="pb-2 border-b border-gray-500">DPP</th>
                        <th class="pb-2 border-b border-gray-500">PPN</th>
                        <th class="pb-2 border-b border-gray-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPesanan as $i => $item)
                        <tr class="{{ $i % 2 !== 0 ? 'bg-gray-100' : 'bg-white' }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp {{ number_format($item->harga) }}</td>
                            <td>{{ $item->jenis_pajak }}/{{$item->persentase_pajak}}%</td>
                            <td>Rp {{ number_format($item->dpp) }}</td>
                            <td>Rp {{ number_format($item->ppn) }}</td>
                            <td>Rp {{ number_format($item->subtotal_detail) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="pt-2 border-t border-gray-500">Subtotal</td>
                        <td class="pt-2 border-t border-gray-500">{{ $transaksi->total_qty }}</td>
                        <td class="pt-2 border-t border-gray-500">Rp {{ number_format($transaksi->subtotal_produk) }}</td>
                    </tr>
            </table>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-truck mr-2 text-gray-500"></i>Biaya Kirim : <span>Rp
                    {{ number_format($transaksi->subtotal_pengiriman) }}</span>
            </div>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-tag mr-2 text-gray-500"></i>Diskon : <span>Rp
                    {{ number_format($transaksi->diskon) }}</span>
            </div>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-money-bill mr-2 text-gray-500"></i>Total : <span>Rp
                    {{ number_format($transaksi->total_pembayaran) }}</span>
            </div>
        </div>
        <div class="max-w-md mx-auto bg-white border rounded-md overflow-hidden shadow-md">
            <div class="p-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-receipt mr-2 text-gray-500 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Detail Transaksi</h2>
                </div>
                <p class="text-gray-600 mt-2">
                    Status dan Tipe Pembayaran
                <p>

                <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tgl. Transaksi</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->cat }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tipe Pembayaran</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->tipe_pembayaran }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Status Pembayaran</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->status_pembayaran }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Status pemesanan</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->status_pemesanan }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kurir</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->nama_kurir }}</dd>
                        </div>
                    </dl>
                </div>
            </div>


            <div class="p-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-map-location-dot text-gray-500 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Alamat Pengiriman</h2>
                </div>
                <p class="text-gray-600 mt-2">
                    Informasi lengkap alamat pengiriman
                <p>
                <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Address</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                {{ $transaksi->jalan }}, {{ $transaksi->jalan_ext }}, {{ $transaksi->blok }}, RT
                                {{ $transaksi->rt }}, RW {{ $transaksi->rw }}, {{ $transaksi->kode_pos }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Provinsi</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->provinsi }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kota/Kabupaten</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kota_kabupaten }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kecamatan</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kecamatan }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kelurahan</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kelurahan }}</dd>
                        </div>

                    </dl>
                </div>


            </div>
        </div>
    </div>
@endsection
