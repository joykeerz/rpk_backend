@extends('layouts.bar')
@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <header class="bg-gray-200 p-4">
        <div class="title flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Pesanan Baru') }} EX
            </h2>
        </div>
    </header>

    @include('layouts.alert')

    <form action="{{ route('pesanan.storeOrder') }}" method="post" class="m-3 border rounded p-3">
        @csrf
        <div class="table_produk w-full">
            <table class="table table-xs table-zebra text-center">
                <thead>
                    <tr>
                        {{-- <th class="pb-2 border-b border-gray-500">SID</th> --}}
                        <th class="pb-2 border-b border-gray-500">Produk</th>
                        <th class="pb-2 border-b border-gray-500">Jumlah</th>
                        <th class="pb-2 border-b border-gray-500">Satuan Unit Produk</th>
                        <th class="pb-2 border-b border-gray-500">Harga</th>
                        <th class="pb-2 border-b border-gray-500">Pajak</th>
                        <th class="pb-2 border-b border-gray-500">%</th>
                        <th class="pb-2 border-b border-gray-500">Jumlah Pesanan</th>
                        <th class="pb-2 border-b border-gray-500">Subtotal</th>
                        <th class="pb-2 border-b border-gray-500">DPP</th>
                        <th class="pb-2 border-b border-gray-500">Pajak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($product as $index=>$item)
                        <tr class="hover" id="tableData">
                            <td class="py-5" id="js_nama_produk">{{ $item->nama_produk }}</td>
                            <td class="py-5 hidden stock_id">{{ $item->sid }}</td>
                            <td class="py-2">{{ $item->jumlah_stok }}</td>
                            <td>{{ $item->satuan_unit_produk }}</td>
                            <td class="py-2 harga_produk">{{ $item->price_value }}</td>
                            <td class="py-2" id="jenis_pajak">{{ $item->jenis_pajak }}</td>
                            <td class="py-2" id="persenan_pajak">{{ $item->persentase_pajak }}</td>
                            <td class="py-5 flex items-center justify-center">
                                <input type="number" name="jumlah_pesanan" class="jumlah_pesanan form-control py-auto"
                                    data-price="{{ $item->price_value }}" data-pajak="{{ $item->jenis_pajak }}"
                                    data-persen="{{ $item->persentase_pajak }}" placeholder="Jumlah Pesanan">
                                <button type="button" class="resetButton ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#ff0000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </button>
                            </td>
                            <td class="py-2 subtotal">0</td>
                            <td class="py-2 dpp-item">0</td>
                            <td class="py-2 pajak-item">0</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="text-left p-4 font-bold">Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div id="totalDisplay" class="">
                                <span id="totalAmount" class="font-bold">0</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span id="totalDpp" class="font-bold">0</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span id="totalPajak" class="font-bold">0</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4 ">
                DPP Terutang:
                <span id="dppTerutang"></span>
            </div>
            <div class="mb-4">
                PPN Terutang:
                <span id="ppnTerutang"></span>
            </div>
            <div class="mt-4 ">
                DPP Dibebaskan:
                <span id="dppDibebaskan"></span>
            </div>
            <div class="mb-4">
                PPN Dibebaskan:
                <span id="ppnDibebaskan"></span>
            </div>
        </div>

        <div class="formContainer inputLabelContainer grid grid-cols-2 gap-0.5">

            <div class="tb_user_id flex flex-col">
                <label for="tb_user_id">Pilih Customer</label>
                <select name="tb_user_id" id="tb_user_id" class="input input-bordered input-sm">
                    <option selected disabled aria-placeholder="pilih user">Pilih User</option>
                    @forelse ($users as $item)
                        <option id="tb_user_id" value="{{ $item->uid }}">{{ $item->name }}</option>
                    @empty
                        <option value="">Tidak ada data</option>
                    @endforelse
                </select>
            </div>
            <div class="tb_alamat_id flex flex-col">
                <label for="tb_alamat_id">Alamat</label>
                <input type="text" name="tb_alamat_id" id="tb_alamat_id" class="input input-bordered input-sm"
                    placeholder="Detail Alamat" disabled>
            </div>
            <div class="tb_kurir_id flex flex-col">
                <label for="tb_kurir_id">Kurir</label>
                <select name="tb_kurir_id" id="tb_kurir_id" class="input input-bordered input-sm">
                    <option selected disabled aria-placeholder="pilih user">Pilih Kurir</option>
                    @foreach ($kurir as $kurir)
                        <option id="tb_kurir_id" value="{{ $kurir->id }}">{{ $kurir->nama_kurir }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="tb_gudang_id" id="tb_gudang_id" value="{{ $gudang_id }}">
                <input type="hidden" name="tb_kode_company" id="tb_kode_company" value="{{ $kodeCompany }}">
            </div>
            <div class="tb_nama_penerima flex flex-col">
                <label for="tb_nama_penerima">Nama Penerima</label>
                <input type="text" name="tb_nama_penerima" id="tb_nama_penerima"
                    class="input input-bordered input-sm">
            </div>
            <div class="tb_nomor_pembayaran flex flex-col">
                <label for="tb_nomor_pembayaran">No. Rekening</label>
                <input type="text" name="tb_nomor_pembayaran" id="tb_nomor_pembayaran"
                    class="input input-bordered input-sm">
            </div>
        </div>
        <button
            class="flex justify-center px-3 py-1 border border-black rounded mt-4 w-1/10 text-center mx-auto hover:bg-green-600 hover:text-white duration-200"
            onclick="confirmCheckoutFire(event)">
            Beli
        </button>

    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var total = 0;
            var dpp_total = 0;
            var pajak_total = 0;
            var dpp_terutang = 0;
            var ppn_terutang = 0;
            var dpp_dibebaskan = 0;
            var ppn_dibebaskan = 0;

            $('.jumlah_pesanan').on('input', updateSubtotal);
            $('#tb_user_id').on('change', updateAlamat);
            $('.resetButton').on('click', resetQuantity);

            function updateSubtotal() {
                var quantity = $(this).val();
                var price = parseFloat($(this).data('price'));
                var persentase = parseFloat($(this).data('persen'));
                var jenis_pajak = $(this).data('pajak');
                var stokId = $(this).closest('tr').find('.stock_id').text();

                var subtotal = quantity * price;
                var dpp = 0;
                var pajak = 0;

                if (jenis_pajak.toLowerCase() === 'include') {
                    dpp = subtotal * (100 / (100 + persentase));
                    pajak = dpp * (persentase / 100);
                    subtotal = dpp + pajak;
                } else if (jenis_pajak.toLowerCase() === 'exclude') {
                    dpp = subtotal;
                    pajak = dpp * (persentase / 100);
                    subtotal = dpp + pajak;
                } else if (jenis_pajak.toLowerCase() === 'dibebaskan') {
                    dpp = subtotal;
                    pajak = subtotal * (persentase / 100);
                    subtotal = dpp;
                }

                subtotal = parseFloat(subtotal).toFixed(2);
                dpp = parseFloat(dpp).toFixed(2);
                pajak = parseFloat(pajak).toFixed(2);
                $(this).closest('tr').find('.subtotal').text(subtotal);
                $(this).closest('tr').find('.dpp-item').text(dpp);
                $(this).closest('tr').find('.pajak-item').text(pajak);

                calculateTotal();
            }

            function calculateTotal() {
                total = 0;
                dpp_total = 0;
                pajak_total = 0;
                dpp_terutang = 0;
                ppn_terutang = 0;
                dpp_dibebaskan = 0;
                ppn_dibebaskan = 0;

                $('.subtotal').each(function() {
                    total += parseFloat($(this).text()) || 0;
                    dpp_total += parseFloat($(this).closest('tr').find('.dpp-item').text()) || 0;

                    var jenis_pajak = $(this).closest('tr').find('#jenis_pajak').text().toLowerCase();
                    if (jenis_pajak === 'include' || jenis_pajak === 'exclude') {
                        pajak_total += parseFloat($(this).closest('tr').find('.pajak-item').text()) || 0;
                        dpp_terutang += parseFloat($(this).closest('tr').find('.dpp-item').text()) || 0;
                        ppn_terutang += parseFloat($(this).closest('tr').find('.pajak-item').text()) || 0;
                    } else {
                        dpp_dibebaskan += parseFloat($(this).closest('tr').find('.dpp-item').text()) || 0;
                        ppn_dibebaskan += parseFloat($(this).closest('tr').find('.pajak-item').text()) || 0;
                    }
                });

                $('#totalAmount').text(total.toFixed(2));
                $('#totalDpp').text(dpp_total.toFixed(2));
                $('#totalPajak').text(pajak_total.toFixed(2));
                $('#dppTerutang').text(dpp_terutang.toFixed(2));
                $('#ppnTerutang').text(ppn_terutang.toFixed(2));
                $('#dppDibebaskan').text(dpp_dibebaskan.toFixed(2));
                $('#ppnDibebaskan').text(ppn_dibebaskan.toFixed(2));
            }

            function updateAlamat() {
                var selectedUserId = $(this).val();
                let usersArray = Object.values({!! json_encode($users) !!});
                let selectedUser = usersArray.find(user => user && user.uid == selectedUserId);

                if (selectedUser) {
                    var alamat = [selectedUser.jalan, selectedUser.kelurahan, selectedUser.kecamatan, selectedUser
                            .kota, selectedUser.provinsi
                        ]
                        .filter(Boolean)
                        .join(', ');

                    $('#tb_alamat_id').val(alamat);
                }
            }

            function resetQuantity(e) {
                e.preventDefault();
                $(this).closest('tr').find('.jumlah_pesanan').val(0).trigger('input');
            }

            $('.resetButton').on('click', resetQuantity);
        });

        function confirmCheckoutFire(e) {
            e.preventDefault();

            let orderDetails = [];
            let total = 0;

            let userData = {
                tb_user_id: $('#tb_user_id').val(),
                tb_alamat_id: $('#tb_alamat_id').val(),
                tb_kurir_id: $('#tb_kurir_id').val(),
                tb_gudang_id: $('#tb_gudang_id').val(),
                tb_kode_company: $('#tb_kode_company').val(),
            };

            let selectedUser = {!! json_encode($users) !!}.find(user => user.uid == userData.tb_user_id);
            let alamatID = selectedUser.alamat_id ? selectedUser.alamat_id : userData.tb_alamat_id;

            let userDataWithAddressID = {
                tb_user_id: userData.tb_user_id,
                tb_alamat_id: alamatID,
                tb_kurir_id: userData.tb_kurir_id,
                tb_gudang_id: userData.tb_gudang_id,
                tb_kode_company: userData.tb_kode_company,
                tb_total_dpp: $('#totalDpp').text(),
                tb_total_ppn: $('#totalPajak').text(),
                tb_dpp_terutang: $('#dppTerutang').text(),
                tb_ppn_terutang: $('#ppnTerutang').text(),
                tb_dpp_dibebaskan: $('#dppDibebaskan').text(),
                tb_ppn_dibebaskan: $('#ppnDibebaskan').text(),
                tb_nama_penerima: $('#tb_nama_penerima').val(),
                tb_nomor_pembayaran: $('#tb_nomor_pembayaran').val(),
            };

            $('tbody tr:not(:last-child)').each(function() {
                let stokId = $(this).find('.stock_id').text();
                let productName = $(this).find('td:first').text();
                let productId = {!! json_encode($product) !!}.find(product => product.nama_produk === productName);
                console.log(productId);
                let price = parseFloat($(this).find('.harga_produk').text());
                let quantity = parseInt($(this).find('.jumlah_pesanan').val());
                let subtotal = parseFloat($(this).find('.subtotal').text());
                let dpp = parseFloat($(this).find('.dpp-item').text());
                let pajak = parseFloat($(this).find('.pajak-item').text());
                let jenis_pajak = $(this).find('#jenis_pajak').text().toLowerCase();
                let persentase = $(this).find('#persenan_pajak').text();

                if (!isNaN(quantity) && quantity > 0) {
                    orderDetails.push({
                        tb_stok_id: stokId,
                        productName: productName,
                        tb_produk_id: productId.produk_id,
                        price: price,
                        tb_jumlah_produk: quantity,
                        subtotal: subtotal,
                        dpp: dpp,
                        ppn: pajak,
                        jenis_pajak: jenis_pajak,
                        persentase_pajak: persentase
                    });
                    total += subtotal;
                }
            });

            let data = {
                orderDetails: [...orderDetails],
                userData: [
                    tb_user_id = userDataWithAddressID.tb_user_id,
                    tb_alamat_id = userDataWithAddressID.tb_alamat_id,
                    tb_kurir_id = userDataWithAddressID.tb_kurir_id,
                    tb_gudang_id = userDataWithAddressID.tb_gudang_id,
                    tb_kode_company = userDataWithAddressID.tb_kode_company,
                    tb_total_dpp = userDataWithAddressID.tb_total_dpp,
                    tb_total_ppn = userDataWithAddressID.tb_total_ppn,
                    tb_dpp_terutang = userDataWithAddressID.tb_dpp_terutang,
                    tb_ppn_terutang = userDataWithAddressID.tb_ppn_terutang,
                    tb_dpp_dibebaskan = userDataWithAddressID.tb_dpp_dibebaskan,
                    tb_ppn_dibebaskan = userDataWithAddressID.tb_ppn_dibebaskan,
                    tb_nama_penerima = userDataWithAddressID.tb_nama_penerima,
                    tb_nomor_pembayaran = userDataWithAddressID.tb_nomor_pembayaran,
                ]
            };

            let productList = orderDetails.map(item => `${item.productName} (Quantity: ${item.tb_jumlah_produk})`).join(
                '<br>');

            Swal.fire({
                title: 'Confirm Checkout',
                html: `<p><strong>User Data:</strong></p>
                <p>User ID: ${userDataWithAddressID.tb_user_id}</p>
                <p>Alamat ID: ${userDataWithAddressID.tb_alamat_id}</p>
                <p>Kurir ID: ${userDataWithAddressID.tb_kurir_id}</p>
                <p>Gudang ID: ${userDataWithAddressID.tb_gudang_id}</p>
                <p>KodeCompany: ${userDataWithAddressID.tb_kode_company}</p>
                <br>
                <p><strong>Order List:</strong></p>
                ${productList}
                <br>
                <p><strong>Total:</strong> ${total}</p>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                let url = '{{ route('pesanan.storeOrder') }}';
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            data: data
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Success!',
                                text: 'Data berhasil diupdate!',
                                icon: 'success',
                                confirmButtonText: 'Submit'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function(response) {
                            console.table(response);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Data gagal diupdate!',
                                icon: 'error',
                                confirmButtonText: 'Submit'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
