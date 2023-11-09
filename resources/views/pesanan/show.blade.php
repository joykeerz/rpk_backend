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
            Detail Transaksi {{ $transaksi->name  }}
        </h2>
    </div>
</header>


<div class="tableContainer m-3 border rounded p-3">
    <table class="w-full text-center border-collapse">
        <thead>
            <tr>
                <th class="pb-2 border-b border-gray-500">No</th>
                <th class="pb-2 border-b border-gray-500">Nama Produk</th>
                <th class="pb-2 border-b border-gray-500">Jumlah</th>
                <th class="pb-2 border-b border-gray-500">Harga</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($detailPesanan as  $i=>$item)
                <tr class="{{ $i % 2 !== 0 ? 'bg-gray-100' : 'bg-white' }}">
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->qty }}</td>
                    <td id="rupiah">{{ $item->harga }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>



</div>
<div class="totalContainer right-0 justify-center bg-black-800 p-3 text-white">
    Total : <span class="rupiah">{{ $transaksi->subtotal_produk }}</span>
</div>

<script>
    const subtotal_produk = document.querySelectorAll('#rupiah');

    subtotal_produk.forEach((item) => {
        item.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.innerHTML);
    })



</script>

@endsection
