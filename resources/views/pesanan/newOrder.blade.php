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
    <header class="bg-gray-200 p-4" ">
                        <div class="title flex justify-between">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Transaksi Baru') }}
                            </h2>
                        </div>
                        </header>

                    <form action="{{route('pesanan.storeOrder')}}" method="post" class="m-3 border rounded p-3">
                                @csrf
                                <div class="table_produk w-full">
                                    <table class="w-full text-center border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="pb-2 border-b border-gray-500">Produk</th>
                                                <th class="pb-2 border-b border-gray-500">Jumlah</th>
                                                <th class="pb-2 border-b border-gray-500">Satuan Unit Produk</th>
                                                <th class="pb-2 border-b border-gray-500">Harga</th>
                                                <th class="pb-2 border-b border-gray-500">Jumlah Pesanan</th>
                                                <th class="pb-2 border-b border-gray-500">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                 @forelse ($product as $index=> $item)
        <tr class="{{ $index % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}" id="tableData">
            <td class="py-5">{{ $item->nama_produk }}</td>
            <td class="py-2">{{ $item->jumlah_stok }}</td>
            <td>{{ $item->satuan_unit_produk }}</td>
            <td class="py-2 harga_produk">{{ $item->harga_produk }}</td>
            <td class="py-5 flex items-center justify-center">
                <input type="number" name="jumlah_pesanan" class="jumlah_pesanan form-control py-auto"
                    data-price="{{ $item->harga_produk }}" placeholder="Jumlah Pesanan">
                <button type="button" class="resetButton ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </button>
            </td>
            <td class="py-2 subtotal"></td>
        </tr>
    @empty
        @endforelse
        <tr>
            <td class="text-left p-4 font-bold">Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div id="totalDisplay" class="">
                    <span id="totalAmount" class="font-bold">0</span>
                </div>
            </td>
        </tr>
        </tbody>
        </table>

        </div>

        <div class="formContainer inputLabelContainer grid grid-cols-2 gap-0.5">

            <div class="tb_user_id flex flex-col">
                <label for="tb_user_id">Pilih User</label>
                <select name="tb_user_id" id="tb_user_id">
                    <option value="" aria-placeholder="pilih user">Pilih User</option>
                    @foreach ($users as $item)
                        <option id="tb_user_id" value="{{ $item->uid }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="tb_alamat_id flex flex-col">
                <label for="tb_alamat_id">Alamat</label>
                <input type="text" name="tb_alamat_id" id="tb_alamat_id" class="form-control" placeholder="ID Alamat">
            </div>
            <div class="tb_kurir_id flex flex-col">
                <label for="tb_kurir_id">Kurir</label>
                <input type="text" name="tb_kurir_id" id="tb_kurir_id" class="form-control" placeholder="ID Kurir">
            </div>
        </div>
        <button class="" onclick="confirmCheckoutFire(event)">
            ya
        </button>
        </form>

        <script>
            $(document).ready(function() {
                $('.jumlah_pesanan').on('input', function() {
                    var quantity = $(this).val();
                    var price = $(this).data('price');
                    var subtotal = quantity * price;

                    // Find the closest row and update the subtotal cell
                    $(this).closest('tr').find('.subtotal').text(subtotal);
                });

                $('#tb_user_id').on('change', function() {
                    var selectedUserId = $(this).val();
                    console.log(selectedUserId+' selected');
                    var selectedUser = {!! json_encode($users) !!}.find(user => user.id == selectedUserId);
                    console.log(selectedUser);
                    if (selectedUser) {
                        var alamat = "";
                        if (selectedUser.jalan) alamat += selectedUser.jalan + ', ';
                        if (selectedUser.kelurahan) alamat += selectedUser.kelurahan + ', ';
                        if (selectedUser.kecamatan) alamat += selectedUser.kecamatan + ', ';
                        if (selectedUser.kota) alamat += selectedUser.kota + ', ';
                        if (selectedUser.provinsi) alamat += selectedUser.provinsi;

                        $('#tb_alamat_id').val(alamat);
                    }
                });

                $(document).ready(function() {
                    $('.jumlah_pesanan').on('input', function() {
                        var orderDetails = [];
                        var total = 0;
                        $('tbody tr:not(:last-child)').each(function() {
                            var productName = $(this).find('td:first').text();
                            var productId = {!! json_encode($product) !!}.find(product => product
                                .nama_produk == productName);

                            var price = parseFloat($(this).find('.harga_produk').text());
                            var quantity = parseInt($(this).find('.jumlah_pesanan').val());
                            var subtotal = quantity * price;

                            if (!isNaN(quantity) && quantity > 0) {
                                orderDetails.push({
                                    productId: productId.produk_id,
                                    price: price,
                                    quantity: quantity,
                                    subtotal: subtotal
                                });
                            }
                            if (!isNaN(quantity) && quantity > 0) {
                                $(this).find('.subtotal').text(subtotal);
                                total += subtotal;

                            } else {
                                $(this).find('.subtotal').text(0);
                            }


                        });
                        var userData = {
                            tb_user_id: $('#tb_user_id').val(),
                            tb_alamat_id: $('#tb_alamat_id').val(),
                            tb_kurir_id: $('#tb_kurir_id').val()
                        };
                        var data = {
                            orderDetails: orderDetails,
                            userData: userData
                        };
                        $('#totalAmount').text(total);

                        console.log(data);

                        $('.resetButton').on('click', function(e) {
                            e.preventDefault();
                            $(this).closest('tr').find('.jumlah_pesanan').val(0).trigger(
                                'input');
                        });
                    });
                });
            });

            function confirmCheckoutFire(e) {
                e.preventDefault();
                let orderDetails = [];
                let total = 0;
                let userData = {
                    tb_user_id: $('#tb_user_id').val(),
                    tb_alamat_id: $('#tb_alamat_id').val(),
                    tb_kurir_id: $('#tb_kurir_id').val()
                };

                let selectedUser = {!! json_encode($users) !!}.find(user => user.id == userData.tb_user_id);
                let alamatID = selectedUser.alamat_id ? selectedUser.alamat_id : userData.tb_alamat_id;


                let userDataWithAddressID = {
                    tb_user_id: userData.tb_user_id,
                    tb_alamat_id: alamatID,
                    tb_kurir_id: userData.tb_kurir_id
                };


                $('tbody tr:not(:last-child)').each(function() {
                    let productName = $(this).find('td:first').text();
                    let productId = {!! json_encode($product) !!}.find(product => product.nama_produk === productName);
                    let price = parseFloat($(this).find('.harga_produk').text());
                    let quantity = parseInt($(this).find('.jumlah_pesanan').val());
                    let subtotal = quantity * price;

                    if (!isNaN(quantity) && quantity > 0) {
                        orderDetails.push({
                            productName: productName,
                            tb_produk_id: productId.produk_id,
                            price: price,
                            tb_jumlah_produk: quantity,
                            subtotal: subtotal
                        });
                        total += subtotal;
                    }
                });

                let data = {
                    orderDetails: [
                        ...orderDetails
                    ],
                    userData: [
                        tb_user_id = userDataWithAddressID.tb_user_id,
                        tb_alamat_id = userDataWithAddressID.tb_alamat_id,
                        tb_kurir_id = userDataWithAddressID.tb_kurir_id
                    ]
                };

                console.log(orderDetails+ ' order details');
                let productList = orderDetails.map(item => `${item.productName} (Quantity: ${item.tb_jumlah_produk})`).join('<br>');
                console.log(productList);
                Swal.fire({
                    title: 'Confirm Checkout',
                    html: `
                    <p><strong>User Data:</strong></p>
                    <p>User ID: ${userDataWithAddressID.tb_user_id}</p>
                    <p>Alamat ID: ${userDataWithAddressID.tb_alamat_id}</p> <!-- Updated to display Alamat ID -->
                    <p>Kurir ID: ${userDataWithAddressID.tb_kurir_id}</p>
                    <br>
                    <p><strong>Order List:</strong></p>
                    ${productList}
                    <br>
                    <p><strong>Total:</strong> ${total}</p>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/pesanan/storeOrder',
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
                                })
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
                                })
                            }
                        });
                    }
                });
            }
        </script>
    @endsection
