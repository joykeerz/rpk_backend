@extends('layouts.dashboard')

@section('page-title')
    Products
@endsection

@section('button-group')
    <button type="button" class="btn btn-sm btn-primary">New Product</button>
    <button type="button" class="btn btn-sm btn-outline-primary">Update Stock</button>
@endsection

@section('section-title')
    Product Data
@endsection

@section('content')
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tipe</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($productsData as $pd)
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pd->nama_produk }}</td>
                        <td>Dummy</td>
                        <td>{{ $pd->stok_produk }}</td>
                        <td>{{ $pd->harga_produk }}</td>
                        <td>
                            <a href="#" class="badge bg-danger">delete</a>
                            <a href="#" class="badge bg-secondary">edit</a>
                        </td>
                    @empty
                        <td colspan="6" align="center">No Data</td>
                    @endforelse

                </tr>
            </tbody>
        </table>
    </div>
@endsection
