<link rel="stylesheet" href="{{ asset('svg.css') }}">
<aside id="logo-sidebar" class="px-3 pb-4 min-h-screen max-h-fit bg-white dark:bg-gray-800 w-64">
    <div class="px-3 pb-4 min-h-screen max-h-fit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('home') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group ">
                    <i class="fa-solid fa-home"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Dashboard RPK</span>
                </a>
            </li>
            <hr>
            @if (Auth::user()->role_id == 5)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg
                            class="pointOfSale w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white dark:bg-gray-800">
                        </svg>
                        <span class="ml-3">Point of Sales</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('barangSubMenu')">
                        <svg stroke="#9CA3AF" class="barangMenu  w-5 h-5 ">
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Produk</span>
                        <svg class="openMenu"></svg>
                    </a>
                    <ul id="barangSubMenu"
                        class="hidden overflow-hidden transition-transform duration-300 bg-gray-500 rounded m-2 ">
                        <!-- Submenu for Barang -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('product.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('product.index') ? 'active' : '' }}">Input
                                Produk</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('product.manage') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('product.manage') ? 'active' : '' }}">Manage
                                Produk</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li>
                    <a href="#" onclick="toggleSubMenu('pesananSubMenu')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="pesanan">
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Pesanan</span>
                        <svg class="submenuOption">
                        </svg>
                    </a>
                    <ul id="pesananSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pesanan.selectTransaksi') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black{{ Request::routeIs('pesanan.selectTransaksi') ? 'active' : '' }}">List
                                Transaksi</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pesanan.selectGudang') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('pesanan.selectGudang') ? 'active' : '' }}">Buat
                                Pesanan Baru
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 4)
                <li class="prices">
                    <a href="{{ route('prices.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('prices.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-tag text-xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Prices</span>
                    </a>
                </li>
                <li class="stok">
                    <a href="#" onclick="toggleSubMenu('stokSubMenu')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="stockIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Stok</span>
                        <svg class="submenuOption">
                        </svg>
                    </a>
                    <ul id="stokSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('stok.showAll') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-black dark:text-white dark:hover:text-black{{ Request::routeIs('stok.showAll') ? 'active' : '' }}">
                                Lihat Semua Stok</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('stok.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black{{ Request::routeIs('stok.index') ? 'active' : '' }}">
                                Stok Berdasarkan Gudang
                            </a>
                        </li>
                    </ul>
                    {{-- <a href="{{ route('stok.showAll') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('stok.index') ? 'active' : '' }}">
                        <svg class="stockIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Stok</span>
                    </a> --}}
                </li>
                <li class="etalase">
                    <a href="{{ route('etalase.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('etalase.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-store text-xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Etalase</span>
                    </a>
                </li>
                <li class="payment-option">
                    <a href="{{ route('payment.option.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('payment.option.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-store text-xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Payment</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li class="user">
                    <a href="{{ route('manage.user.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('manage.user.index') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">User</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <li class="kategori">
                    <a href="{{ route('category.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('category.index') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Kategori</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('gudangSubMenu')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 9v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9" />
                            <path d="M9 22V12h6v10M2 10.6L12 2l10 8.6" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Gudang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 "
                        id="gudangSubMenu"> <!-- Nested submenu -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('gudang.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('gudang.create') ? 'active' : '' }}">Input
                                Gudang</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('gudang.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('gudang.index') ? 'active' : '' }}">Manage
                                Gudang</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('companySubMenu')">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Company</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul id="companySubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <!-- Submenu for Barang -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('company.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('company.create') ? 'active' : '' }}">Input
                                Company</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('company.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('company.index') ? 'active' : '' }}">Manage
                                Company</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('branchSubMenu')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Branch</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul id="branchSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">

                        <li class="hover:bg-gray-100">
                            <a href="{{ route('branch.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('branch.create') ? 'active' : '' }}">Input
                                Branch</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('branch.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('branch.index') ? 'active' : '' }}">Manage
                                Branch</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('customerSubMenu')">
                        <svg class="customerIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Customer</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="customerSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('customer.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('customer.create') ? 'active' : '' }}">Input
                                Customer</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('customer.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('customer.index') ? 'active' : '' }}">Manage
                                Customer</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 3)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('laporanSubMenu')">
                        <i class="fa-solid fa-file-lines text-2xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Laporan</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="laporanSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.stock') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('laporan.stock') ? 'active' : '' }}">Stok</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.penjualan') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('laporan.penjualan') ? 'active' : '' }}">Penjualan</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('bannerSubMenu')">
                        <i class="fa-solid fa-images text-2xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Banner</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="bannerSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('banner.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('banner.create') ? 'active' : '' }}">Input
                                Banner</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('banner.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('banner.index') ? 'active' : '' }}">Manage
                                Banner</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('beritaSubMenu')">
                        <i class="fa-solid fa-newspaper text-2xl text-gray-500"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Berita</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="beritaSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('berita.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('berita.create') ? 'active' : '' }}">Input
                                Berita</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('berita.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('berita.index') ? 'active' : '' }}">Manage
                                Berita</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('pajakSubMenu')">
                        <i class="fa-solid fa-coins text-gray-500 text-2xl"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Pajak</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="pajakSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pajak.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('pajak.create') ? 'active' : '' }}">Input
                                Pajak</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pajak.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('pajak.index') ? 'active' : '' }}">Manage
                                Pajak</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 2)
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        onclick="toggleSubMenu('satuanUnitSubMenu')">
                        <i class="fa-solid fa-boxes-stacked text-gray-500 text-2xl"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Satuan Unit</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="satuanUnitSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('satuan-unit.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('satuan-unit.create') ? 'active' : '' }}">Input
                                Satuan Unit</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('satuan-unit.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black {{ Request::routeIs('satuan-unit.index') ? 'active' : '' }}">Manage
                                Satuan Unit</a>
                        </li>
                    </ul>
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
