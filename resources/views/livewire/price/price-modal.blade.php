@if ($isOpen)
    <div class="fixed inset-0 z-50 overflow-auto bg-neutral-950 bg-opacity-75 flex justify-center items-center">
        <div class="bg-neutral-50 rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">New Price</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeModal">
                    ✕
                </button>
            </div>

            <form wire:submit="addPrice">
                <div class="flex mt-2">
                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Produk*</span>
                        </div>
                        <select wire:model.defer="produkId" class="select select-bordered">
                            <option disabled selected>Pilih satu</option>
                            @forelse ($stocks as $key => $stock)
                                <option value="{{ $stock->produk_id }}">{{ $stock->nama_produk }}</option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('produkId')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Harga*</span>
                        </div>
                        <input wire:model="pricevalue" type="text" placeholder="Cth 1000"
                            class="input input-bordered w-full max-w-xs" />
                        @error('pricevalue')
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
