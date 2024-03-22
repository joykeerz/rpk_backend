@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
@endsection
<div>
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between items-center">
            <h2 class="font-normal text-md text-gray-800 leading-tight">
                {{ __('Manage Stok Etalase') }}
            </h2>

            <div class="flex items-center">
                <div class="button">
                    <a class="btn btn-sm btn-primary" href="#" wire:click="openModal">
                        <i class="fa-solid fa-add"></i>
                        Tambah Stok
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-6">
            <!-- Start coding here -->
            <div class="bg-white  relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Search" required="">
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900">Status Type :</label>
                            <select wire:model.live="statusFilter"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="">All</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3" wire:click="setSortBy('produk.nama_produk')">
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
                                <th scope="col" class="px-4 py-3" wire:click="setSortBy('stok_etalase.jumlah_stok')">
                                    <button class="flex items-center">
                                        @if ($sortBy !== 'stok_etalase.jumlah_stok')
                                            <i class="fa-solid fa-sort mr-1"></i>
                                        @elseif ($sortDir === 'ASC')
                                            <i class="fa-solid fa-sort-up mr-1"></i>
                                        @else
                                            <i class="fa-solid fa-sort-down mr-1"></i>
                                        @endif
                                        Stok
                                        Etalase
                                    </button>
                                </th>
                                <th scope="col" class="px-4 py-3" wire:click="setSortBy('stok_gudang')">
                                    <button class="flex items-center">
                                        @if ($sortBy !== 'stok_gudang')
                                            <i class="fa-solid fa-sort mr-1"></i>
                                        @elseif ($sortDir === 'ASC')
                                            <i class="fa-solid fa-sort-up mr-1"></i>
                                        @else
                                            <i class="fa-solid fa-sort-down mr-1"></i>
                                        @endif
                                        Stok
                                        Gudang
                                    </button>
                                </th>
                                <th scope="col" class="px-4 py-3" wire:click="setSortBy('stok_etalase.is_active')">
                                    <button class="flex items-center">
                                        @if ($sortBy !== 'stok_etalase.is_active')
                                            <i class="fa-solid fa-sort mr-1"></i>
                                        @elseif ($sortDir === 'ASC')
                                            <i class="fa-solid fa-sort-up mr-1"></i>
                                        @else
                                            <i class="fa-solid fa-sort-down mr-1"></i>
                                        @endif
                                        Status
                                    </button>
                                </th>
                                <th scope="col" class="px-4 py-3" wire:click="setSortBy('stok_etalase.updated_at')">
                                    <button class="flex items-center">
                                        @if ($sortBy !== 'stok_etalase.updated_at')
                                            <i class="fa-solid fa-sort mr-1"></i>
                                        @elseif ($sortDir === 'ASC')
                                            <i class="fa-solid fa-sort-up mr-1"></i>
                                        @else
                                            <i class="fa-solid fa-sort-down mr-1"></i>
                                        @endif
                                        Last
                                        update
                                    </button>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($stokEtalase as $stok)
                                <tr class="border-b" wire:key="{{ $stok->id }}">
                                    <td class="px-4 py-3">
                                        {{ $stokEtalase->firstItem() + $loop->index }}</td>
                                    <td scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $stok->nama_produk }}</td>
                                    <td class="px-4 py-3">
                                        @if ($editingStockId == $stok->id)
                                            <div class="flex gap-1 mt-1">
                                                <input wire:model="editingJumlahStock" type="text"
                                                    placeholder="Ex. 100"
                                                    class="input input-sm input-bordered w-full max-w-xs" />
                                                <button wire:click="updateEtalaseStock" class="btn btn-sm btn-outline">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span>
                                                {{ $stok->jumlah_stok }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 ">{{ $stok->stok_gudang }}</td>
                                    <td class="px-4 py-3 text-green-500">
                                        @if ($stok->is_active)
                                            <div class="form-control">
                                                <label class="label cursor-pointer">
                                                    <span class="label-text mr-2">Active</span>
                                                    <input wire:click="toggleEtalase({{ $stok->id }})"
                                                        type="checkbox" class="toggle" checked />
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-control">
                                                <label class="label cursor-pointer">
                                                    <span class="label-text">Inactive</span>
                                                    <input wire:click="toggleEtalase({{ $stok->id }})"
                                                        type="checkbox" class="toggle" />
                                                </label>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $stok->updated_at }}</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        {{-- <button wire:click="delete({{ $stok->id }})"
                                            onclick="confirm('anda yakin ingin hapus stok etalase {{ $stok->nama_produk }}') ? '' : event.stopImmediatePropagation()"
                                            class="px-3 py-1 bg-red-500 text-white rounded">
                                            X
                                        </button> --}}
                                        <div class="dropdown dropdown-end">
                                            <div tabindex="0" role="button" class="btn m-1"><i
                                                    class="fa-solid fa-ellipsis-vertical"></i></div>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li>
                                                    <button wire:click="delete({{ $stok->id }})"
                                                        onclick="confirm('anda yakin ingin hapus stok etalase {{ $stok->nama_produk }}') ? '' : event.stopImmediatePropagation()"
                                                        class="btn btn-sm btn-outline">
                                                        <i class="fa-solid fa-trash"></i>Delete
                                                    </button>
                                                    @if ($editingStockId == $stok->id)
                                                        <button wire:click="cancelChange"
                                                            class="btn btn-sm btn-outline mt-1">
                                                            <i class="fa-solid fa-xmark"></i>Cancel
                                                        </button>
                                                    @else
                                                        <button wire:click="changeStock({{ $stok->id }})"
                                                            class="btn btn-sm btn-outline mt-1">
                                                            <i class="fa-solid fa-pencil"></i>Edit
                                                        </button>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada stok etalase</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                            <select wire:model.live="perPage"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $stokEtalase->links() }}
                </div>
            </div>
        </div>
    </section>

    {{-- Modal --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
            <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold mb-4">Tambah Stok Etalase</h2>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeModal">
                        ✕
                    </button>
                </div>
                <form wire:submit="addStock">
                    <div class="flex mt-2">
                        <label class="form-control w-full max-w-xs mr-2">
                            <div class="label">
                                <span class="label-text">Produk/Stok Gudang*</span>
                            </div>
                            <select wire:model.defer="stok_id" class="select select-bordered">
                                <option disrebled selected>Pilih satu</option>
                                @forelse ($stokGudang as $key => $stok)
                                    <option value="{{ $stok->id }}">{{ $stok->nama_produk }}
                                    </option>
                                @empty
                                    <option disabled selected>Tidak ada stok di company ini</option>
                                @endforelse
                            </select>
                            @error('stok_id')
                                <div class="label">
                                    <span class="label-text-alt text-red-700">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>

                        <label class="form-control w-full max-w-xs">
                            <div class="label">
                                <span class="label-text">Jumlah*</span>
                            </div>
                            <input wire:model.defer="jumlah_stok" type="number" placeholder="1"
                                class="input input-bordered w-full max-w-xs" />
                            @error('jumlah_stok')
                                <div class="label">
                                    <span class="label-text-alt text-red-700">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-add"></i>
                            Tambah
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif
    {{-- /Modal --}}
</div>

@section('script')
@endsection
