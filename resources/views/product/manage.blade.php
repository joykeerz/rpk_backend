@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<header class="bg-gray-200 p-4">
    <h2>
        Manage Product
    </h2>
</header>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this product?");
    }
</script>

<div class="overflow-auto m-3">
<input type="text" id="searchInput" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search...">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokData as $pd)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Dummy</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->jumlah_stok }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->harga_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('product.delete', ['id' => $pd->pid]) }}" onclick="return confirmDelete();" class="bg-red-500 text-white rounded-md px-3 py-1">delete</a>
                        <a href="{{route('product.show', ['id' => $pd->pid])}}" class="bg-gray-500 text-white rounded-md px-3 py-1 ml-2">edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
