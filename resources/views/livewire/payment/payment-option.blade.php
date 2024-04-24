@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('plugins')
    {{-- code --}}
@endsection

<div>
    <header class="bg-gray-200 p-4 max-w-full">
        <div class="flex justify-between">
            <h2>
                Manage Payment Options
            </h2>
            <div class="flex gap-1">
                <div class="button">
                    <button class="btn btn-sm btn-primary" wire:click="openModal">
                        <i class="fa-solid fa-add"></i>
                        New Payment
                    </button>
                </div>

                <div class="button">
                    <a class="btn btn-sm btn-outline" href="{{ route('payment.type.index') }}">
                        <i class="fa-solid fa-add"></i>
                        Payment Types
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <table id="myTable" class="table table-sm table-zebra min-w-full">
            <thead>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('rekening_tujuan.name')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'rekening_tujuan.name')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Nama Rek.
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('rekening_tujuan.bank_acc_number')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'rekening_tujuan.bank_acc_number')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        No. Rek.
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('payment_terms.name')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'payment_terms.name')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Payment Term
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                    wire:click="setSortBy('payment_options.payment_type')">
                    <button class="flex items-center">
                        @if ($sortBy !== 'payment_options.payment_type')
                            <i class="fa-solid fa-sort mr-1"></i>
                        @elseif ($sortDir === 'ASC')
                            <i class="fa-solid fa-sort-up mr-1"></i>
                        @else
                            <i class="fa-solid fa-sort-down mr-1"></i>
                        @endif
                        Tipe
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </thead>
            <tbody>
                @include('livewire.payment.payment-option-row')
            </tbody>
        </table>
    </div>

    <div class="py-4 px-3">
        <div class="flex">
            <div class="flex space-x-4 items-center mb-3">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Per-page</span>
                    </div>
                    <select wire:model.live='perPage' class="select select-sm select-bordered">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
            </div>
        </div>
        {{ $paymentOptions->links('pagination::tailwind') }}
    </div>

    @include('livewire.payment.payment-option-modal')

    @include('livewire.payment.payment-option-edit')

</div>

@section('script')
    {{-- code --}}
@endsection
