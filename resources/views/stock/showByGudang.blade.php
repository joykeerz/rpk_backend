@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <header class="bg-gray-200 p-4 flex justify-between">
        <h2>
            Viewing stocks in {{ $gudang->nama_gudang }}
        </h2>
        <div class="button">
            <a class="btn btn-primary align-center w-full border border-black p-2 rounded hover:bg-gray-800 hover:text-white duration-200"
                href="{{ route('stok.create', ['id' => $gudang->id]) }}">Add Stock</a>
        </div>
    </header>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this stock?");
        }
    </script>
    @if (Session::has('message'))
        <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" role="alert" id="alertMessage">
            <p>{{ Session::get('message') }}.</p>
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
        <script>
            // After the page loads
            document.addEventListener('DOMContentLoaded', function() {
                var alert = document.getElementById('alertMessage');

                if (alert) {
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 5000); // 5000 milliseconds = 5 seconds
                }

                // Optionally, you might want to add functionality to close the alert with the close button
                var closeButton = alert.querySelector('.close-button');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        alert.style.display = 'none';
                    });
                }
            });
        </script>
    @endif
    <div class="overflow-auto m-3">
        <input type="text" id="searchInput"
            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            placeholder="Search...">
        <div class="border border-gray-400 rounded">
            <table class="min-w-full bg-white text-center rounded">
                <thead>
                    <tr class="text-center ">
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Increase/Decrase
                        </th>

                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $stock)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white'}}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $stock->kode_produk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_produk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $stock->jumlah_stok }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($stock->harga_produk) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('stok.increase', ['id' => $stock->sid]) }}" method="post">
                                    @csrf
                                    <input class="border rounded-md py-2 px-3 w-full" type="number" name="qty_stock"
                                        id="qty_stock" placeholder="Ex. -1 or 2">
                                </form>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                <a href="{{ route('stok.detail', ['id' => $stock->sid]) }}"
                                    class="m-2 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                    <svg class="showIcon"> </svg>
                                </a>
                                <a href="{{ route('stok.delete', ['id' => $stock->sid]) }}"
                                    class="m-2 bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded"
                                    onclick="return confirmDelete();">
                                    <svg class="deleteIcon"> </svg>
                                </a>
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
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection
