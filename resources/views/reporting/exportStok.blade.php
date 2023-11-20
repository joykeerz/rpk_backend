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
    <div class="table-responsive mt-4">
        @if ($from != null && $to != null)
            <h3 class="alert alert-success">Laporan Stok Dari {{ $from }} S.d {{ $to }}</h3>
        @else
            <h3 class="alert alert-success">Laporan Stok Keseluruhan S.d {{$currentDate}}</h3>
        @endif
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Gudang</th>
                    <th>Alamat</th>
                    <th>Tgl.Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $stock->kode_produk }}</td>
                        <td>{{ $stock->nama_produk }}</td>
                        <td>{{ $stock->nama_kategori }}</td>
                        <td>{{ 'Rp ' . number_format($stock->harga_produk, 2) }}</td>
                        <td>{{ $stock->jumlah_stok }}</td>
                        <td>{{ $stock->nama_gudang }}</td>
                        <td>
                            <p>
                                {{ $stock->jalan }},
                                {{ $stock->blok }},
                                RT {{ $stock->rt }},
                                RW {{ $stock->rw }},
                                {{ $stock->kelurahan }},
                                {{ $stock->kecamatan }},
                                {{ $stock->kota_kabupaten }},
                                {{ $stock->provinsi }}
                            </p>
                        </td>
                        <td>
                           {{$stock->cat}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
