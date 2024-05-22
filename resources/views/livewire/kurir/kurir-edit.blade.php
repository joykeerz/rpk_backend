@if ($isEdit)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">Edit Kurir</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeEdit">
                    ✕
                </button>
            </div>

            <form wire:submit="saveEdit" enctype="multipart/form-data">
                <div class="flex mt-2 gap-1">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Nama*</span>
                        </div>
                        <input wire:model.defer="namaKurirEdit" type="text" placeholder="Cth. Free Ongkir"
                            class="input input-bordered w-full max-w-xs" />
                        @error('namaKurirEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2 text-black">
                        <div class="label">
                            <span class="label-text">Tipe Delivery*</span>
                        </div>
                        <select wire:model="deliveryTypeEdit" class="select select-bordered">
                            <option disabled>Pilih Tipe</option>
                            @forelse ($deliveryTypeEnum as $key => $type)
                                <option value="{{ $type }}" {{ $type == $deliveryTypeEnum ?? selected }}>
                                    {{ $type }}
                                </option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('deliveryTypeEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                </div>

                <div class="flex mt-2 gap-1">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Fixed Price*</span>
                        </div>
                        <input wire:model.defer="fixedPriceEdit" type="number" placeholder="1"
                            class="input input-bordered w-full max-w-xs" />
                        @error('fixedPriceEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Deskripsi*</span>
                        </div>
                        <textarea wire:model.defer="descriptionEdit" cols="10" rows="3" class="input input-bordered w-full max-w-xs"></textarea>
                        @error('descriptionEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                </div>

                <div class="flex mt-2 gap-1">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Persentase Margin*</span>
                        </div>
                        <input wire:model="marginPercentageEdit" type="number" placeholder="1"
                            class="input input-bordered w-full max-w-xs" />
                        @error('marginPercentageEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Icon Kurir</span>
                        </div>
                        <input wire:model="imageKurirEdit" type="file"
                            class="mt-1 block w-full
                        rounded-md shadow-sm focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1" />
                        @error('imageKurirEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                        @if ($imageKurirEdit)
                            <img class="rounded w-20 h-20 mt-2 block" src="{{ asset('storage/' . "$imageKurirEdit") }}"
                                alt="imageKurir">
                        @endif
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
