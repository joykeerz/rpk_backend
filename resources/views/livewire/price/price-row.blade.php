@forelse ($prices as $price)
    <tr class="hover" wire:key="{{ $price->id }}">
        <td class="px-6 py-4 whitespace-nowrap">{{ $prices->firstItem() + $loop->index }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $price->kode_produk }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $price->nama_produk }}</td>
        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($price->price_value) }}</td>
        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <button wire:click="openEdit({{ $price->id }})" class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-pencil"></i>Edit
                            <span wire:loading wire:target="openEdit" class="loading loading-spinner loading-xs"></span>
                        </button>
                    </li>
                    {{-- <li>
                        <button wire:click="delete({{ $price->id }})" onclick="return confirmDelete();"
                            class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-trash"></i>Delete
                        </button>
                    </li> --}}
                </ul>
            </div>
        </td>
    </tr>

@empty
    <tr>
        <td colspan="5">No Data</td>
    </tr>
@endforelse
