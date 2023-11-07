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

    @forelse ($transaksi as $item)
    <div class="tableContainer">
        <table class="w-full text-center">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Nama Pemesan</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pemesanan</th>
                    <th>Total</th>
                    <th>Detail Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->status_pembayaran }}</td>
                    <td>{{ $item->status_pemesanan }}</td>
                    <td>null</td>
                    <td>
                        <a href="{{route('pesanan.show',['id' =>$item->id ])}}">bismilah</a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>


    @empty
        <h1>tidak ada data yang tersedia</h1>
    @endforelse


@endsection
