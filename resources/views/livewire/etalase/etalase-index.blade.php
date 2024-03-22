<div>
    <header class="bg-gray-200 p-4 max-w-full">
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

    <div class="m-1">
        <table id="myTable" class="table table-sm table-zebra min-w-full">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#
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
                @include('livewire.etalase.etalase-row')
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
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
            </div>
        </div>
        {{ $stokEtalase->links('pagination::tailwind') }}
    </div>

    @include('livewire.etalase.ealase-modal')

</div>
