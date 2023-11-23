@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection


@section('content')
    <header class=" bg-gray-200 p-4">
        <div class="title justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pesanan {{ $transaksi->name }}
            </h2>
        </div>
    </header>

    <form method="post" action="{{ route('pesanan.update', ['id' => $transaksi->tid]) }}">
        @csrf
        <div class="columns-2 m-3">
            <div class="tableContainer p-3 max-w-md mx-auto bg-white border rounded-md overflow-hidden shadow-md">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="pb-2 border-b border-gray-500">No</th>
                            <th class="pb-2 border-b border-gray-500">Nama Produk</th>
                            <th class="pb-2 border-b border-gray-500">Jumlah</th>
                            <th class="pb-2 border-b border-gray-500">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailPesanan as $i => $item)
                            <tr class="{{ $i % 2 !== 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->harga) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="pt-2 border-t border-gray-500">Subtotal</td>
                            <td class="pt-2 border-t border-gray-500">{{ $transaksi->total_qty }}</td>
                            <td class="pt-2 border-t border-gray-500">Rp {{ number_format($transaksi->subtotal_produk) }}
                                <input type="hidden" id="subtotalPrice" value="{{ $transaksi->subtotal_produk }}">
                            </td>
                        </tr>
                </table>
                <div class="p-2 m-2  border rounded-sm">
                    <i class="fa-solid fa-truck mr-2 text-gray-500"></i>Biaya Kirim :
                    <span>
                        <input
                            class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                            type="text" name="tb_biaya_kirim" id="tb_biaya_kirim" onkeyup="calculateBiayaKirim()"
                            value="{{ $transaksi->subtotal_pengiriman }}">
                        @error('tb_biaya_kirim')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </span>
                </div>
                <div class="p-2 m-2  border rounded-sm">
                    <i class="fa-solid fa-tag mr-2 text-gray-500"></i>Diskon :
                    <span>
                        <input
                            class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                            onkeyup="calculateDiscount()" type="text" name="tb_diskon" id="discountPercentage"
                            value="{{ $transaksi->diskon }}">
                        @error('tb_diskon')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </span>
                </div>
                <div class="p-2 m-2  border rounded-sm">
                    <i class="fa-solid fa-money-bill mr-2 text-gray-500"></i>Total :
                    <span>
                        <input
                            class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                            type="text" name="tb_total_pembayaran" id="tb_total_pembayaran"
                            value="{{ $transaksi->total_pembayaran }}">
                        @error('tb_total_pembayaran')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </span>
                </div>
            </div>
            <div class="max-w-md mx-auto bg-white border rounded-md overflow-hidden shadow-md">
                <div class="p-4">
                    <div class="flex items-center">
                        <i class="fa-solid fa-receipt mr-2 text-gray-500 text-xl"></i>
                        <h2 class="text-xl font-semibold text-gray-800">Detail Transaksi</h2>
                    </div>
                    <p class="text-gray-600 mt-2">
                        Status dan Tipe Pembayaran
                    <p>

                    <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm">
                        <dl class="-my-3 divide-y divide-gray-100 text-sm">
                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Tgl. Transaksi</dt>
                                <dd class="text-gray-700 sm:col-span-2">

                                    <input
                                        class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1"
                                        disabled type="datetime-local" name="tb_external_id" id="tb_external_id"
                                        value="{{ $transaksi->cat }}">
                                    @error('tb_external_id')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror

                                </dd>
                            </div>
                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Tipe Pembayaran</dt>
                                <dd class="text-gray-700 sm:col-span-2">
                                    <select name="cb_tipe_pembayaran" id="cb_tipe_pembayaran"
                                        class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                        <option selected value="{{ $transaksi->tipe_pembayaran }}">current:
                                            {{ $transaksi->tipe_pembayaran }}</option>
                                        <option>Transfer Bank</option>
                                        <option>Bayar di Tempat</option>
                                    </select>
                                    @error('cb_tipe_pembayaran')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </dd>
                            </div>

                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Status Pembayaran</dt>
                                <dd class="text-gray-700 sm:col-span-2">

                                    <select name="cb_status_pembayaran" id="cb_status_pembayaran"
                                        class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                        <option selected value="{{ $transaksi->status_pembayaran }}">current:
                                            {{ $transaksi->status_pembayaran }}</option>
                                        <option>sudah dibayar</option>
                                        <option>belum dibayar</option>
                                    </select>
                                    @error('cb_status_pembayaran')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror

                                </dd>
                            </div>

                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Status pemesanan</dt>

                                <dd class="text-gray-700 sm:col-span-2">
                                    <select name="cb_status_pemesanan" id="cb_status_pemesanan"
                                        class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                        <option selected value="{{ $transaksi->status_pemesanan }}">current :
                                            {{ $transaksi->status_pemesanan }}</option>
                                        <option>diproses</option>
                                        <option>dikirim</option>
                                        <option>selesai</option>
                                    </select>
                                    @error('cb_status_pemesanan')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </dd>
                            </div>

                            <div class="grid grid-cols-1 gap-1 p-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                                <dt class="font-medium text-gray-900">Kurir</dt>
                                <dd class="text-gray-700 sm:col-span-2">
                                    <select name="cb_kurir" id="cb_kurir"
                                        class="mt-1 block w-full rounded-m shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border border-gray-300 p-1">
                                        @forelse ($kurir as $kurir)
                                            <option value="{{ $kurir->id }}"
                                                @if ($kurir->id == $transaksi->kurir_id) selected @endif>{{ $kurir->nama_kurir }}
                                            </option>
                                        @empty
                                            <option disabled>No data</option>
                                        @endforelse
                                    </select>
                                    @error('cb_kurir')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
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
                    <div class="buttonContainer flex justify-center">
                        <button type="submit"
                            class="px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection

<script>
    // Function to calculate the discounted price
    function calculateDiscount() {
        // Get the values from input fields
        var originalPrice = parseFloat(document.getElementById('tb_total_pembayaran').value);
        var subtotalPrice = parseFloat(document.getElementById('subtotalPrice').value);
        var discountInput = document.getElementById('discountPercentage');
        var discountPercentage = parseFloat(discountInput.value);

        if (discountPercentage > 100) {
            alert('Diskon tidak boleh lebih dari 100%');
            return;
        }

        if (originalPrice <= 0) {
            originalPrice = subtotalPrice;
        }

        // Check if the discount percentage is not provided or is 0, reset to the original subtotal
        if (isNaN(discountPercentage) || discountPercentage === 0) {
            document.getElementById('tb_total_pembayaran').value = subtotalPrice.toFixed(2);
            return;
        }

        // Calculate the discounted price
        var discountAmount = (discountPercentage / 100) * originalPrice;
        var discountedPrice = originalPrice - discountAmount;

        document.getElementById('tb_total_pembayaran').value = discountedPrice.toFixed(2);
    }

    // Event listener for the "input" event on the discount input field
    document.getElementById('discountPercentage').addEventListener('input', function() {
        // Check if the input value is empty
        if (this.value === '') {
            // If empty, reset the total payment to the original subtotal
            var subtotalPrice = parseFloat(document.getElementById('subtotalPrice').value);
            document.getElementById('tb_total_pembayaran').value = subtotalPrice.toFixed(2);
        } else {
            // If not empty, calculate the discount
            calculateDiscount();
        }
    });

    // Function to calculate the total payment including the delivery cost
    function calculateBiayaKirim() {
        var biayaKirim = parseFloat(document.getElementById('tb_biaya_kirim').value);
        var totalPembayaran = parseFloat(document.getElementById('tb_total_pembayaran').value);
        var subtotalPrice = parseFloat(document.getElementById('subtotalPrice').value);

        // Check if the input value is empty
        if (isNaN(biayaKirim) || biayaKirim < 0) {
            // If empty or negative, reset the total payment to the original subtotal
            document.getElementById('tb_total_pembayaran').value = subtotalPrice.toFixed(2);
        } else {
            // If not empty, calculate the total payment
            var totalPembayaran = biayaKirim + totalPembayaran;
            document.getElementById('tb_total_pembayaran').value = totalPembayaran.toFixed(2);
        }
    }

    // Event listener for the "input" event on the tb_biaya_kirim input field
    document.getElementById('tb_biaya_kirim').addEventListener('input', function() {
        // Call the calculateBiayaKirim function when the input value changes
        calculateBiayaKirim();
    });
</script>
