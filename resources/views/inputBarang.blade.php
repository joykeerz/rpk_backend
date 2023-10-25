@extends('layouts.bar')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<hr>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                New Product
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="mb-3">
                      <label for="" class="form-label">Nama Produk</label>
                      <input type="text" class="form-control" name="tb_product_name" id="tb_product_name" placeholder="">
                      <small id="helpId" class="form-text text-muted"></small>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Tipe</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                        </select>
                      <small id="helpId" class="form-text text-muted"></small>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Stok</label>
                      <input type="number" class="form-control" name="tb_product_name" id="tb_product_name" value="0" placeholder="">
                      <small id="helpId" class="form-text text-muted">boleh dikosongkan</small>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Harga</label>
                      <input type="number" class="form-control" name="tb_product_name" id="tb_product_name" value="0" placeholder="">
                      <small id="helpId" class="form-text text-muted"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
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
