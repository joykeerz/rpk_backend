@forelse ($couriers as $kurir)
    <tr class="hover" wire:key="{{ $kurir->id }}">
        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $kurir->nama_kurir }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $kurir->delivery_type }}</td>
        <td class="px-6 py-4 whitespace-nowrap">Rp{{ $kurir->fixed_price }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $kurir->margin_percentage }}%</td>
        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <button wire:click="openEdit({{ $kurir->id }})" class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-pencil"></i>Edit
                            <span wire:loading wire:target="openEdit" class="loading loading-spinner loading-xs"></span>
                        </button>
                    </li>
                    <li>
                        <button wire:click="delete({{ $kurir->id }})" onclick="return confirmDelete();"
                            class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-trash"></i>Delete
                            <span wire:loading wire:target="delete" class="loading loading-spinner loading-xs"></span>
                        </button>
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
