<div>
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between">
            <h2>
                Manage Stok Etalase
            </h2>
            <div class="button">
                <button class="btn btn-sm btn-primary" wire:click="openModal">
                    <i class="fa-solid fa-add"></i>
                    New Etalase
                </button>
            </div>
        </div>
    </header>

    @include('livewire.etalase.etalase-alert')
    @include('livewire.etalase.etalase-search-box')

    <div class="overflow-auto m-1">
        <table id="myTable" class="table table-sm table-zebra min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stok Etalase
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stok Gudang
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Updated</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokEtalase as $stock)
                    @include('livewire.etalase.etalase-row')
                @empty
                    <tr>
                        <td colspan="6">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $stokEtalase->links('pagination::tailwind') }}

    </div>

    @include('livewire.etalase.ealase-modal')

</div>
