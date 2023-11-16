<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EXPORT PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid mt-4">
        <h3 class="alert alert-success">Laporan Stok Dari {{ $from }} S.d {{ $to }}</h3>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Customer</th>
                    <th>Tipe Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pemesanan</th>
                    <th>Total</th>
                    <th>Tgl. Trans</th>
                    <th>Metode Kirim</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $trans)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $trans->name }}</td>
                        <td>{{ $trans->tipe_pembayaran }}</td>
                        <td>{{ $trans->status_pembayaran }}</td>
                        <td>{{ $trans->status_pemesanan }}</td>
                        <td>{{ 'IDR ' . number_format($trans->subtotal_produk, 2) }}</td>
                        <td>{{ $trans->cat }}</td>
                        <td>{{ $trans->nama_kurir }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
