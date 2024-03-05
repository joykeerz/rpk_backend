<div>
    <header class="bg-gray-200 p-4">
        <div class="flex justify-between">
            <h2>
                Manage Stok Etalase
            </h2>
            <div class="button">
                <button class="btn btn-sm btn-primary" wire:click="openModal">
                    <i class="fa-solid fa-add"></i>
                    New Etalase
                </button>
            </div>
        </div>
    </header>

    @if (session('message'))
        <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" role="alert" id="alertMessage">
            <p>{{ Session::get('message') }}.</p>
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
    @elseif(session('error'))
        <div class="bg-red-700 border-t border-b border-white-500 text-white px-4 py-3 relative" role="alert"
            id="alertMessage">
            <p>{{ Session::get('error') }}.</p>
            <button type="button" data-dismiss="alert" aria-label="Close"
                class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </button>
        </div>
    @endif
    @include('layouts.searchbar', ['routeName' => 'banner.index'])

    <div class="overflow-auto m-3">
        <table id="myTable" class="table table-sm table-zebra min-w-full bg-white text-center">
            <thead>
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3  text-xs font-medium text-gray-500 uppercase tracking-wider">#
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Produk
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jumlah
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Updated</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokEtalase as $stock)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->nama_produk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->jumlah_stok }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->is_active }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stock->updated_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center gap-1">
                            <button href="{{ route('banner.delete', ['id' => $stock->id]) }}"
                                onclick="return confirmDelete();" class="btn btn-sm btn-error">
                                <i class="fa-solid fa-trash text-white"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

        {{ $stokEtalase->links('pagination::tailwind') }}

    </div>

    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
            <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold mb-4">New Etalase</h2>
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeModal">✕
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

</div>
@script
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $wire.on('stockAdded', () => {
                console.log('stock added');

                var alert = document.getElementById('alertMessage');

                if (alert) {
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 5000);
                }

                var closeButton = alert.querySelector('.close-button');
                if (closeButton) {
                    closeButton.addEventListener('click', function() {
                        alert.style.display = 'none';
                    });
                }

                // $('#myTable').DataTable().destroy();
                // $('#myTable').DataTable({
                //     responsive: true,
                //     searching: false,
                //     ordering: true,
                //     paging: false,
                //     info: false,
                // });
            });
        })
    </script>
@endscript
