@if ($isOpen)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">New Payment Option</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeModal">
                    ✕
                </button>
            </div>

            <form wire:submit="addPayment">
                <div class="flex mt-2">
                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Rekening Tujuan*</span>
                        </div>
                        <select wire:model.defer="rekeningTujuanId" class="select select-bordered">
                            <option disrebled selected>Pilih satu</option>
                            @forelse ($rekeningTujuanList as $key => $rekening)
                                <option value="{{ $rekening->id }}">{{ $rekening->display_name }} -
                                    {{ $rekening->bank_acc_number }}
                                </option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('rekeningTujuanId')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Payment Terms*</span>
                        </div>
                        <select wire:model.defer="paymentTermId" class="select select-bordered">
                            <option disrebled selected>Pilih satu</option>
                            @forelse ($paymentTerms as $key => $term)
                                <option value="{{ $term->id }}">{{ $term->name }} - {{ $term->tipe_penjualan }}
                                </option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('paymentTermId')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Tipe Payment*</span>
                        </div>
                        <select wire:model.defer="paymentType" class="select select-bordered">
                            <option disrebled selected>Pilih satu</option>
                            @forelse ($paymentTypes as $paymentType)
                                <option value="{{ $paymentType->id }}">{{ $paymentType->display_name }}</option>
                            @empty
                                <option disrebled selected>No Data</option>
                            @endforelse
                        </select>
                        @error('paymentType')
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
