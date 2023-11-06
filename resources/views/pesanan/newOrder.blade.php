@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.jumlah_pesanan').on('input', function () {
            var quantity = $(this).val();
            var price = $(this).data('price');
            var subtotal = quantity * price;

            // Find the closest row and update the subtotal cell
            $(this).closest('tr').find('.subtotal').text(subtotal);
        });
    });
</script>


<header class="bg-gray-200 p-4" ">
    <div class="title flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Baru') }}
        </h2>
    </div>
</header>

<form action="route('pesanan.newOrder')" method="post" class="m-3 border rounded p-3">
    @csrf
    <div class="table_produk w-full">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr>
                    <th class="pb-2 border-b border-gray-500">Produk</th>
                    <th class="pb-2 border-b border-gray-500">Jumlah</th>
                    <th class="pb-2 border-b border-gray-500">Harga</th>
                    <th class="pb-2 border-b border-gray-500">Jumlah Pesanan</th>
                    <th class="pb-2 border-b border-gray-500">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($product as $index => $item)
                    <tr class="{{ $index % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="py-2">{{ $item->nama_produk }}</td>
                        <td class="py-2">{{ $item->jumlah_stok }}</td>
                        <td class="py-2 harga_produk">{{ $item->harga_produk }}</td>
                        <td class="py-2">
                            <input type="number" name="jumlah_pesanan" class="jumlah_pesanan form-control" data-price="{{ $item->harga_produk }}" placeholder="Jumlah Pesanan">
                        </td>
                        <td class="py-2 subtotal"></td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="formContainer inputLabelContainer grid grid-cols-2 gap-0.5">

        <div class="tb_user_id flex flex-col">
            <label for="tb_user_id">ID User</label>
            <input type="text" name="tb_user_id" id="tb_user_id" class="form-control" placeholder="ID User">
        </div>
        <div class="tb_alamat_id flex flex-col">
            <label for="tb_alamat_id">Alamat</label>
            <input type="text" name="tb_alamat_id" id="tb_alamat_id" class="form-control" placeholder="ID Alamat">
        </div>
        <div class="tb_kurir_id flex flex-col">
            <label for="tb_kurir_id">Kurir</label>
            <input type="text" name="tb_kurir_id" id="tb_kurir_id" class="form-control" placeholder="ID Kurir">
        </div>
    </div>
</form>

@endsection
