<link rel="stylesheet" href="{{ asset('svg.css') }}">
<aside id="logo-sidebar" class="px-3 pb-4 min-h-screen max-h-fit w-64 bg-neutral-800 dark:bg-neutral-700">
    <div class="px-3 pt-24 pb-4 min-h-screen max-h-fit">
        <ul class="space-y-2 font-medium">
            @if (Auth::user()->role_id == 5)
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group">
                        <svg
                            class="pointOfSale w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover group-hover  bg-gray-800">
                        </svg>
                        <span class="ml-3">Point of Sales</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <li>
                    <a href="#" onclick="toggleSubMenu('productSubMenu')"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('product.manage') ? 'active' : '' }}">
                        <i class="fa-solid w-5 fa-boxes-stacked"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Produk</span>
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <ul id="productSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('product.manage') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black{{ Request::routeIs('pesanan.selectTransaksi') ? 'active' : '' }}">List
                                Produk</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('category.index') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('category.index') ? 'active' : '' }}">Kategori
                                Produk
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li>
                    <a href="#" onclick="toggleSubMenu('pesananSubMenu')"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Pesanan</span>
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <ul id="pesananSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pesanan.selectTransaksi') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black{{ Request::routeIs('pesanan.selectTransaksi') ? 'active' : '' }}">List
                                Transaksi</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pesanan.selectGudang') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('pesanan.selectGudang') ? 'active' : '' }}">Buat
                                Pesanan Baru
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 4)
                <li class="prices">
                    <a href="{{ route('prices.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('prices.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Harga</span>
                    </a>
                </li>
                <li class="stok">
                    <a href="#" onclick="toggleSubMenu('stokSubMenu')"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Stok</span>
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <ul id="stokSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('stok.showAll') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-black  hover:text-black{{ Request::routeIs('stok.showAll') ? 'active' : '' }}">
                                Lihat Semua Stok</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('stok.index') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black{{ Request::routeIs('stok.index') ? 'active' : '' }}">
                                Stok Berdasarkan Gudang
                            </a>
                        </li>
                    </ul>
                    {{-- <a href="{{ route('stok.showAll') }}"
                        class="flex items-center p-2 rounded-lg  hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('stok.index') ? 'active' : '' }}">
                        <svg class="stockIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Stok</span>
                    </a> --}}
                </li>
                <li class="etalase">
                    <a href="{{ route('etalase.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50  hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('etalase.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-cells"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Etalase</span>
                    </a>
                </li>
                <li class="payment-option">
                    <a href="{{ route('payment.option.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('payment.option.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Payment</span>
                    </a>
                </li>
                <li class="kurir">
                    <a href="{{ route('kurir-index.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('kurir-index.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Kurir</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <li class="user">
                    <a href="{{ route('manage.user.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('manage.user.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-user w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">User</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="{{ route('gudang.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('gudang.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-warehouse w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Gudang</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group"
                        onclick="toggleSubMenu('companySubMenu')">
                        <i class="fa-solid fa-building w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Company</span>
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <ul id="companySubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <!-- Submenu for Barang -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('company.index') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('company.index') ? 'active' : '' }}">Manage
                                Company</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('branch.index') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('branch.index') ? 'active' : '' }}">Manage
                                Branch</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li>
                    <a href="{{ route('customer.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group  {{ Request::routeIs('customer.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-group w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Customer</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 3)
                <li>
                    <a href="#"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group"
                        onclick="toggleSubMenu('laporanSubMenu')">
                        <i class="fa-solid fa-file-lines w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Laporan</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="laporanSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.stock') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('laporan.stock') ? 'active' : '' }}">Stok</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.penjualan') }}"
                                class="pl-5 block py-2 text-neutral-50 hover:text-dark  hover:text-black {{ Request::routeIs('laporan.penjualan') ? 'active' : '' }}">Penjualan</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="{{ route('banner.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group  {{ Request::routeIs('banner.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-images w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Banner</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>

                    <a href="{{ route('berita.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group {{ Request::routeIs('berita.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-newspaper w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Berita</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>

                    <a href="{{ route('pajak.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group  {{ Request::routeIs('pajak.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-coins w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Pajak</span>
                    </a>

                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="{{ route('satuan-unit.index') }}"
                        class="flex items-center p-2 rounded-lg text-neutral-50 hover:bg-gray-100 hover:bg-gray-700 group  {{ Request::routeIs('satuan-unit.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked w-5"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Satuan Unit</span></a>
                </li>
            @endif
        </ul>
    </div>
</aside>




<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            document.getElementById('logout-form').submit();
        }
    }

    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault();
        confirmLogout();
    });

    function toggleSubMenu(subMenuId) {
        var subMenu = document.getElementById(subMenuId);
        subMenu.classList.toggle('hidden');
    }
</script>
