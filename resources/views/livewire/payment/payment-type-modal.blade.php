@if ($isInsert)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">New Payment Type</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeInsert">
                    ✕
                </button>
            </div>

            <form wire:submit="createType">
                <div class="flex mt-2">
                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Nama Tipe*</span>
                        </div>
                        <input wire:model="paymentType" type="text" placeholder="Cth. Tunai"
                            class="input input-bordered w-full max-w-xs" />
                        @error('paymentType')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Display Name*</span>
                        </div>
                        <input wire:model="displayName" type="text" placeholder="Cth. Tunai(Cod)"
                            class="input input-bordered w-full max-w-xs" />
                        @error('displayName')
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
                        <span wire:loading wire:target="createType" class="loading loading-spinner loading-xs"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>
@endif
