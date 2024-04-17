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
            <div class="button">
                <button class="btn btn-sm btn-primary" wire:click="openModal">
                    <i class="fa-solid fa-add"></i>
                    New Payment
                </button>
            </div>
        </div>
    </header>

    <div class="container">
        <table id="myTable" class="table table-sm table-zebra min-w-full">
            <thead>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                    Rek.
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">No. Rek.
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Payment
                    Term</th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe
                </th>
                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
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
