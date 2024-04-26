@forelse ($paymentOptions as $paymentOption)
    <tr class="hover" wire:key="{{ $paymentOption->id }}">
        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $paymentOption->rekening_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $paymentOption->bank_acc_number }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $paymentOption->term_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $paymentOption->display_name }}</td>
        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <button wire:click="openEdit({{ $paymentOption->id }})" class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-pencil"></i>Edit
                        </button>
                    </li>
                    <li>
                        <button wire:click="delete({{ $paymentOption->id }})" onclick="return confirmDelete();"
                            class="btn btn-sm btn-outline">
                            <i class="fa-solid fa-trash"></i>Delete
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
