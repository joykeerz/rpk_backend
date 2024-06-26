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
    <header class=" bg-gray-200 p-4">
        <div class="title flex justify-between">
            <h2 class="text-xl text-gray-800 leading-tight">
                Detail Pesanan {{ $transaksi->name }}
            </h2>
            <button wire:click="toggleEdit({{ $transaksi->tid }})" type="button" class="btn btn-sm btn-primary">
                @if ($isEdit)
                    <i class="fa-solid fa-pencil"></i>
                    Selesai
                    <span wire:loading wire:target="toggleEdit" class="loading loading-spinner loading-xs"></span>
                @else
                    <i class="fa-solid fa-pencil"></i>
                    Edit
                    <span wire:loading wire:target="toggleEdit" class="loading loading-spinner loading-xs"></span>
                @endif
            </button>
        </div>
    </header>

    <div class="container columns-2 m-2">
        @include('livewire.pesanan.detail-pesanan-alert')

        {{-- Column 1 --}}
        <div class="p-3 bg-white border rounded-md overflow-x-scroll shadow-md">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr>
                        <th class="pb-2 border-b border-gray-500">#</th>
                        <th class="pb-2 border-b border-gray-500">Produk</th>
                        <th class="pb-2 border-b border-gray-500">Jumlah</th>
                        <th class="pb-2 border-b border-gray-500">Harga</th>
                        <th class="pb-2 border-b border-gray-500">Pajak</th>
                        <th class="pb-2 border-b border-gray-500">DPP</th>
                        <th class="pb-2 border-b border-gray-500">PPN</th>
                        <th class="pb-2 border-b border-gray-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPesanan as $i => $item)
                        <tr class="hover">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp {{ number_format($item->harga) }}</td>
                            <td>{{ $item->jenis_pajak }}/{{ $item->persentase_pajak }}%</td>
                            <td>Rp {{ number_format($item->dpp) }}</td>
                            <td>Rp {{ number_format($item->ppn) }}</td>
                            <td>Rp {{ number_format($item->subtotal_detail) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="pt-2 border-t border-gray-500">Subtotal</td>
                        <td colspan="3" class="pt-2 border-t border-gray-500">{{ $transaksi->total_qty }}</td>
                        <td class="pt-2 border-t border-gray-500">{{ $transaksi->total_dpp }}</td>
                        <td class="pt-2 border-t border-gray-500">{{ $transaksi->total_ppn }}</td>
                        <td class="pt-2 border-t border-gray-500">Rp {{ number_format($transaksi->subtotal_produk) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="pt-2 border-t border-gray-500">DPP Terutang</td>
                        <td colspan="3" class="pt-2 border-t border-gray-500">Rp
                            {{ number_format($transaksi->dpp_terutang) }}</td>
                        <td colspan="2" class="pt-2 border-t border-gray-500">DPP Dibebaskan</td>
                        <td colspan="2" class="pt-2 border-t border-gray-500">Rp
                            {{ number_format($transaksi->dpp_dibebaskan) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="pt-2 border-t border-gray-500">PPN Terutang</td>
                        <td colspan="3" class="pt-2 border-t border-gray-500">Rp
                            {{ number_format($transaksi->ppn_terutang) }}</td>
                        <td colspan="2" class="pt-2 border-t border-gray-500">PPN Dibebaskan</td>
                        <td colspan="2" class="pt-2 border-t border-gray-500">Rp
                            {{ number_format($transaksi->ppn_dibebaskan) }}</td>
                    </tr>
            </table>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-truck mr-2 text-gray-500"></i>Biaya Kirim : <span>Rp
                    {{ number_format($transaksi->subtotal_pengiriman) }}</span>
            </div>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-tag mr-2 text-gray-500"></i>Diskon/Voucher : <span>Rp
                    {{ number_format($transaksi->diskon) }}</span>
            </div>
            <div class="p-2 m-2  border rounded-sm">
                <i class="fa-solid fa-money-bill mr-2 text-gray-500"></i>Grand Total : <span>Rp
                    {{ number_format($transaksi->total_pembayaran) }}</span>
            </div>
        </div>

        {{-- Column 2 --}}
        <div class="max-w-xl bg-white border rounded-md overflow-hidden shadow-md">
            @if (session()->has('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fa-solid fa-receipt mr-2 text-gray-500 text-xl"></i>
                        <h2 class="text-xl font-semibold text-gray-800">Detail Transaksi</h2>
                    </div>
                    <div class="flex">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-sm m-1">
                                Sync SO
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                <span wire:loading wire:target="generateSalesOrder"
                                    class="loading loading-spinner loading-xs"></span>
                            </div>
                            <ul tabindex="0"
                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                @if ($transaksi->status_pemesanan === 'menunggu verifikasi')
                                    <li><a>Transaksi belum diverivikasi</a></li>
                                @else
                                    @if ($isDocumentOut)
                                        <li>
                                            <a wire:loading.class="hidden"
                                                wire:click.prevent="generateSalesOrder">Generate
                                                SO
                                            </a>
                                            <span wire:loading wire:target="generateSalesOrder"
                                                class="loading loading-spinner loading-xs"></span>
                                        </li>
                                    @else
                                        <li><a>SO Sudah Dibuat!</a></li>
                                    @endif
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <p class="text-gray-600 mt-2">
                    Status dan Tipe Pembayaran
                <p>

                <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">

                        @if ($isDocumentOut)
                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Kode SO</dt>
                                <dd class="text-gray-700 sm:col-span-2">Generate So Terlebih dahulu</dd>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Kode SO</dt>
                                <dd class="text-gray-700 sm:col-span-2">{{ $SoCode }}</dd>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tgl. Transaksi</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->cat }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tipe Pembayaran </dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                @if ($isEdit)
                                    <select wire:model="tipePembayaran" class="select select-bordered w-full max-w-xs">
                                        <option selected>{{ $transaksi->tipe_pembayaran }}</option>
                                        <option>
                                            {{ $transaksi->tipe_pembayaran == 'Transfer Bank' ? 'Tunai' : 'Transfer Bank' }}
                                        </option>
                                    </select>
                                @else
                                    {{ $transaksi->tipe_pembayaran }}
                                @endif
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">No. Rekening</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->nomor_pembayaran }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Status Pembayaran</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                @if ($isEdit)
                                    <select wire:model="statusPembayaran"
                                        class="select select-bordered w-full max-w-xs">
                                        <option selected>{{ $transaksi->status_pembayaran }}</option>
                                        <option>
                                            {{ $transaksi->status_pembayaran == 'belum dibayar' ? 'sudah dibayar' : 'belum dibayar' }}
                                        </option>
                                    </select>
                                @else
                                    {{ $transaksi->status_pembayaran }}
                                @endif
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Status pemesanan</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                @if ($isEdit)
                                    <select wire:model="statusPemesanan"
                                        class="select select-bordered w-full max-w-xs">
                                        @foreach ($statusPemesananOpt as $option)
                                            <option {{ $transaksi->status_pemesanan == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    {{ $transaksi->status_pemesanan }}
                                @endif
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kurir</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                @if ($isEdit)
                                    <select wire:model="kurir" class="select select-bordered w-full max-w-xs">
                                        @foreach ($kurirOpt as $option)
                                            <option value="{{ $option->id }}"
                                                {{ $transaksi->kurir_id == $option->id ? 'selected' : '' }}>
                                                {{ $option->nama_kurir }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    {{ $transaksi->nama_kurir }}
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>


            <div class="p-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-map-location-dot text-gray-500 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Alamat Pengiriman</h2>
                </div>
                <p class="text-gray-600 mt-2">
                    Informasi lengkap alamat pengiriman
                <p>
                <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Address</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                {{ $transaksi->jalan }}, {{ $transaksi->jalan_ext }}, {{ $transaksi->blok }}, RT
                                {{ $transaksi->rt }}, RW {{ $transaksi->rw }}, {{ $transaksi->kode_pos }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Provinsi</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->provinsi }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kota/Kabupaten</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kota_kabupaten }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kecamatan</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kecamatan }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Kelurahan</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $transaksi->kelurahan }}</dd>
                        </div>

                    </dl>
                </div>
            </div>

            <div class="p-4">
                <div class="flex items-center">
                    <i class="fa-solid fa-credit-card text-gray-500 mr-2 text-xl"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Payment Info</h2>
                </div>
                <p class="text-gray-600 mt-2">
                    Informasi Tujuan Pembayaran (Bulog)
                <p>
                <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tujuan</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                {{ $paymentOptionInfo->display_name }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">No. Rek.</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $paymentOptionInfo->bank_acc_number }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Tipe Payment</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $paymentOptionInfo->payment_type_display }}
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-medium text-gray-900">Payment Term</dt>
                            <dd class="text-gray-700 sm:col-span-2">{{ $paymentOptionInfo->name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-2">

        <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-200">
            <div class="collapse-title text-xl font-medium">
                Out Documents
            </div>
            <div class="collapse-content">
                @forelse ($salesOrders as $salesOrder)
                    @forelse ($salesOrder->outDocuments as $outDocument)
                        <div class="flex items-center justify-between px-4 mb-2 mt-4">
                            {{-- OUT(name | sale.order) --}}
                            <span>
                                <div class="badge badge-neutral">Code: {{ $outDocument->out_document_code }}</div>
                            </span>
                            {{-- STATUS(state | stock.picking) --}}
                            <span>
                                <div class="badge badge-neutral">
                                    Status: {{ $outDocument->out_document_status }}
                                </div>
                            </span>
                        </div>
                    @empty
                        no data, please sync to erp first
                    @endforelse
                    <table class="table table-sm table-zebra border bg-white">
                        <thead>
                            <th>Produk</th>
                            <th>Ordered</th>
                            <th>Done</th>
                            <th>UOM</th>
                        </thead>
                        <tbody>
                            @forelse ($salesOrder->orderLines as $orderLine)
                                <tr class="hover">
                                    <td>{{ $orderLine->produk->nama_produk }}</td>
                                    <td>{{ $orderLine->ordered_quantity }}</td>
                                    <td>{{ $orderLine->qty_done }}</td>
                                    <td>{{ $orderLine->uom }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                @empty
                    no data, please sync to erp first
                @endforelse
            </div>
        </div>

    </div>
</div>

@section('script')
    {{-- code --}}
@endsection
