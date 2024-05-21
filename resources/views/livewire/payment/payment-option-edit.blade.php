@if ($isEdit)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">Edit Payment Option</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeEdit">
                    ✕
                </button>
            </div>

            <form wire:submit="saveEdit">
                <div class="flex mt-2">
                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Rekening Tujuan*</span>
                        </div>
                        <select wire:model.defer="rekeningTujuanIdEdit" class="select select-bordered">
                            <option disabled selected>Pilih satu</option>
                            @forelse ($rekeningTujuanList as $key => $rekening)
                                <option {{ $rekening->rekening_tujuan_id == $rekeningTujuanIdEdit ? 'selected' : '' }}
                                    value="{{ $rekening->id }}">
                                    {{ $rekening->display_name }} -
                                    {{ $rekening->bank_acc_number }}
                                </option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('rekeningTujuanIdEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Payment Terms*</span>
                        </div>
                        <select wire:model.defer="paymentTermIdEdit" class="select select-bordered">
                            <option disabled selected>Pilih satu</option>
                            @forelse ($paymentTerms as $key => $term)
                                <option {{ $rekening->payment_term_id == $paymentTermIdEdit ? 'selected' : '' }}
                                    value="{{ $term->id }}">{{ $term->name }} - {{ $term->tipe_penjualan }}
                                </option>
                            @empty
                                <option disabled selected>Tidak ada data</option>
                            @endforelse
                        </select>
                        @error('paymentTermIdEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full max-w-xs mr-2">
                        <div class="label">
                            <span class="label-text">Tipe Payment*</span>
                        </div>
                        <select wire:model.defer="paymentTypeEdit" class="select select-bordered">
                            @forelse ($paymentTypes as $paytype)
                                <option value="{{ $paytype->id }}"
                                    {{ $paymentTypeEdit == $paytype ? 'selected' : '' }}>{{ $paytype->display_name }}
                                </option>
                            @empty
                                <option disabled selected>No Data</option>
                            @endforelse
                        </select>
                        @error('paymentTypeEdit')
                            <div class="label">
                                <span class="label-text-alt text-red-700">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                </div>
                <div class="flex justify-end mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-add"></i>
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endif
