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
        @include('layouts.searchbar', [
            'routeName' => 'prices.index',
            'placeholder' => 'Masukkan nama harga',
        ])
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
                        <td class="px-6 py-4 whitespace-nowrap price-value">{{ $price->price_value }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center">
                            <span class="edit-price btn btn-sm btn-primary" data-id="{{ $price->id }}"
                                style="cursor: pointer;">
                                <i class="fa-solid fa-pencil"></i>
                            </span>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="editPriceModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 hidden">
        <div class="relative p-8 mx-auto max-w-md">
            <div class="bg-white rounded shadow-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Edit Price Value</h2>
                    <input type="text" class="border p-2 w-full" id="newPriceValue" placeholder="Enter new price value">
                </div>
                <div class="flex justify-end p-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" id="savePriceChanges">Save Changes</button>
                    <button class="ml-2 text-gray-600" id="closeModal">Cancel</button>
                </div>
            </div>
        </div>
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

            $('.edit-price').on('click', function() {
                var priceId = $(this).data('id');
                var currentPrice = $(this).closest('tr').find('.price-value').text();
                console.log('price ID: ' + priceId);

                // Set the current price value in the modal input
                $('#newPriceValue').val(currentPrice);

                // Show the custom modal
                $('#editPriceModal').removeClass('hidden');

                $('#savePriceChanges').on('click', function() {
                    saveChanges(priceId);
                });

                $('#closeModal').on('click', function() {
                    // Hide the custom modal
                    $('#editPriceModal').addClass('hidden');
                });

                // Handle Enter key press event
                $('#newPriceValue').on('keypress', function(e) {
                    if (e.which === 13) {
                        saveChanges(priceId);
                    }
                });
            });

            function saveChanges(priceId) {
                // Get the new price value from the modal input
                var newPriceValue = $('#newPriceValue').val();

                // Make an AJAX request to update the price
                $.ajax({
                    method: 'PUT',
                    url: 'api/ajax/prices/' + priceId,
                    data: {
                        _token: '{{ csrf_token() }}',
                        price_value: newPriceValue,
                    },
                    success: function(response) {
                        console.log(response);
                        console.log('updated id on : ' + priceId);
                        alert(response.message);
                        // Update the displayed value on success
                        $(`[data-id=${priceId}]`).closest('tr').find('.price-value').text(
                            newPriceValue);
                        // Hide the custom modal
                        $('#editPriceModal').addClass('hidden');
                    },
                    error: function(error) {
                        alert(error.responseJSON.error);
                        console.log(error);
                    },
                });
            }
        });
    </script>
@endsection
