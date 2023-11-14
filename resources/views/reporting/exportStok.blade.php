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
    <div class="container mt-4">
        <h3 class="alert alert-success">{{ $stocks }}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Gudang</th>
                    <th scope="col">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $stock)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $stock->kode_produk }}</td>
                        <td>{{ $stock->nama_produk }}</td>
                        <td>{{ $stock->nama_kategori }}</td>
                        <td>{{ 'IDR ' . number_format($stock->harga_produk, 2) }}</td>
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
