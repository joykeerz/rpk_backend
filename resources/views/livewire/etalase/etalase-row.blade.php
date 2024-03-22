@forelse ($stokEtalase as $stock)
    <tr class="hover" wire:key="{{ $stock->id }}">
        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_produk }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($editingStockId == $stock->id)
                <div class="flex gap-1 mt-1">
                    <input wire:model="editingJumlahStock" type="text" placeholder="Ex. 100"
                        class="input input-sm input-bordered w-full max-w-xs" />
                    <button wire:click="updateEtalaseStock" class="btn btn-sm btn-outline">
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            @else
                <span>
                    {{ $stock->jumlah_stok }}
                </span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->stok_gudang }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($stock->is_active)
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text mr-2">Active</span>
                        <input wire:click="toggleEtalase({{ $stock->id }})" type="checkbox" class="toggle" checked />
                    </label>
                </div>
            @else
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Inactive</span>
                        <input wire:click="toggleEtalase({{ $stock->id }})" type="checkbox" class="toggle" />
                    </label>
                </div>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->updated_at }}</td>
        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <button wire:click="delete({{ $stock->id }})" onclick="return confirmDelete();"
                            class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-trash"></i>Delete
                        </button>
                        @if ($editingStockId == $stock->id)
                            <button wire:click="cancelChange" class="btn btn-sm btn-outline mt-1">
                                <i class="fa-solid fa-xmark"></i>Cancel
                            </button>
                        @else
                            <button wire:click="changeStock({{ $stock->id }})" class="btn btn-sm btn-outline mt-1">
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
        <td colspan="6">No Data</td>
    </tr>
@endforelse
