@extends('layouts.dashboard')

@section('page-title')
    Products
@endsection

@section('button-group')
    <button type="button" class="btn btn-sm btn-primary">New Category</button>
    <button type="button" class="btn btn-sm btn-outline-primary">Update Category</button>
@endsection

@section('section-title')
    Category Data
@endsection

@section('content')
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($kategoriData as $kd)
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pd->nama_kategori }}</td>
                        <td>{{ $pd->deskripsi_kategori }}</td>
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
