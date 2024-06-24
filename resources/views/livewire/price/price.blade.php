@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    {{-- code --}}
@endsection

<div>
    <header class="bg-gray-200 p-4 max-w-full">
        <div class="flex justify-between">
            <h2>
                Manage Prices
            </h2>
            <div class="flex gap-1">
                <div class="button">
                    <button class="btn btn-sm btn-primary" wire:click="openModal">
                        <i class="fa-solid fa-add"></i>
                        New Price
                        <span wire:loading wire:target="openModal" class="loading loading-spinner loading-xs"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="container">

        @include('livewire.price.price-search')

        @include('livewire.price.price-alert')

        <table id="myTable" class="table table-sm table-zebra min-w-full">
            <thead>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('produk.kode_produk')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'produk.kode_produk')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Kode
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('produk.nama_produk')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'produk.nama_produk')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Produk
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('prices_1.price_value')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'prices_1.price_value')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Harga
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </thead>
            <tbody>
                @include('livewire.price.price-row')
            </tbody>
        </table>
    </div>

    <div class="py-4 px-3">
        <div class="flex">
            <div class="flex space-x-4 items-center mb-3">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Per-page</span>
                    </div>
                    <select wire:model.live='perPage' class="select select-sm select-bordered">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
            </div>
        </div>
        {{ $prices->links() }}
    </div>

    @include('livewire.price.price-modal')

    @include('livewire.price.price-edit')

</div>

@section('script')
    {{-- code --}}
@endsection
