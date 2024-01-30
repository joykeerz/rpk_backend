@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
@endsection

@section('content')
    <header class="bg-gray-200 p-4 flex justify-between">
        <h2>
            Viewing stocks in {{ $gudang->nama_gudang }}
        </h2>
        <div class="button">
            <a class="btn btn-sm btn-primary" href="{{ route('stok.create', ['id' => $gudang->id]) }}">
                <i class="fa-solid fa-plus"></i>
                Add Stock
            </a>
        </div>
    </header>

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
    @endif
    <div class="overflow-auto m-3">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr class="text-center">
                        <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
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
                        <tr class="hover">
                            <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap">{{ $stock->kode_produk }}</td>
                            <td class="whitespace-nowrap">{{ $stock->nama_produk }}</td>
                            <td class="whitespace-nowrap">{{ $stock->nama_kategori }}</td>
                            <td class="whitespace-nowrap">{{ $stock->jumlah_stok }}</td>
                            <td class="whitespace-nowrap">Rp {{ number_format($stock->harga_stok) }}</td>
                            <td class="whitespace-nowrap">
                                <form action="{{ route('stok.increase', ['id' => $stock->sid]) }}" method="post">
                                    @csrf
                                    <input class="border rounded-md py-2 px-3 w-full" type="number" name="qty_stock"
                                        id="qty_stock" placeholder="Ex. -1 or 2">
                                </form>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                                <a href="{{ route('stok.detail', ['id' => $stock->sid]) }}"
                                    class="btn btn-sm btn-primary mr-1">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <a href="{{ route('stok.delete', ['id' => $stock->sid]) }}" class="btn btn-sm btn-error"
                                    onclick="return confirmDelete();">
                                    <i class="fa-solid fa-trash text-gray-200"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $stocks->links('pagination::tailwind') }}

        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection

@section('script')
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this stock?");
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('alertMessage');

            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000);
            }

            var closeButton = alert.querySelector('.close-button');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    alert.style.display = 'none';
                });
            }
        });
    </script>
@endsection
