@if ($isOpen)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">New Etalase</h2>
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
