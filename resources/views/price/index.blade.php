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
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this Price?");
        }
    </script>
    <header class="bg-gray-200 p-4">
        <h2>
            Manage Prices in
            @if (empty($currentEntity))
                Selindo
            @else
                {{ $currentEntity->nama_company }}
            @endif
        </h2>
    </header>

    @include('layouts.alert')


    <div class="overflow-auto m-3">
        <form action="{{ route('prices.store') }}" method="POST">
            @csrf
            <div class="flex justify-center items-center gap-2 m-3 p-3 border rounded">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Harga*</span>
                    </div>
                    <input value="{{ old('tb_price') }}" type="text" name="tb_price" id="tb_price"
                        placeholder="Type here" class="input input-bordered input-accent w-full max-w-xs" />
                    @error('tb_price')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </label>

                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Produk*</span>
                    </div>
                    <select class="select select-bordered rounded-md py-2 px-3 w-full" name="cb_produk" id="cb_produk">
                        @forelse ($stocks as $stock)
                            <option value="{{ $stock->produk_id }}">{{ $stock->nama_produk }}</option>
                        @empty
                            <option value="">No Product Yet</option>
                        @endforelse
                    </select>
                </label>

                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">&nbsp</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-1/2">Add Price</button>
                </label>
            </div>
        </form>
        @if (!empty($currentEntity))
            <div
                class="flex justify-between items-center w-100 p-2 rounded border border-opacity-30 border-slate-500 bg-blue-950 text-white">
                <h1 class="font-medium">Prices In {{ $currentEntity->nama_company }}</h1>
            </div>
        @endif
        @include('layouts.searchbar', ['routeName' => 'prices.index'])
        <table id="myTable" class="table table-sm table-zebra hover">
            <thead class="border border-b-1">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kode
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prices as $price)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $price->kode_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $price->nama_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $price->price_value }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                            <a href="{{ route('prices.show', ['id' => $price->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <link rel="stylesheet" href="{{ asset('svg.css') }}">
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true,
                searching: false,
                ordering: true,
                paging: false,
                info: false,
            });
        });
    </script>
@endsection
