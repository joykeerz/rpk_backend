@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
{{-- <script>
    const searchInput = document.getElementById('searchInput');
    const dataTable = document.getElementById('dataTable');

    // Access your initial data for the table
    const originalData = {!!json_encode($productsData) !!};

    // Function to filter the data
    function filterTable(searchText) {
        const filteredData = originalData.filter(product => {
            return product.nama_produk.toLowerCase().includes(searchText.toLowerCase());
        });

        if (filteredData.length === 0) {
            dataTable.innerHTML = '<tr><td class="text-center" colspan="6">hilang</td></tr>';
            return;
        }

        // Clear the table
        dataTable.innerHTML = '';

        // Populate the table with filtered data
        filteredData.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">${product.id}</td>
                <td class="px-6 py-4 whitespace-nowrap">${product.nama_produk}</td>
                <td class="px-6 py-4 whitespace-nowrap">Dummy</td>
                <td class="px-6 py-4 whitespace-nowrap">${product.stok_produk}</td>
                <td class="px-6 py-4 whitespace-nowrap">${product.harga_produk}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('product.delete', ['id'=>$product.id]) }}" class="bg-red-500 text-white rounded-md px-3 py-1">delete</a>
                    <a href="#" class="bg-gray-500 text-white rounded-md px-3 py-1 ml-2">edit</a>
                </td>
            `;
            dataTable.appendChild(row);
        });
    }

    // Event listener for the search input
    searchInput.addEventListener('input', function() {
        filterTable(this.value.trim());
    });

    // Initialize the table with the original data
    filterTable('');
</script> --}}
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
                @forelse ($productsData as $pd)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->nama_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Dummy</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->stok_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pd->harga_produk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('product.delete', ['id' => $pd->id]) }}" onclick="return confirmDelete();" class="bg-red-500 text-white rounded-md px-3 py-1">delete</a>
                        <a href="#" class="bg-gray-500 text-white rounded-md px-3 py-1 ml-2">edit</a>
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
