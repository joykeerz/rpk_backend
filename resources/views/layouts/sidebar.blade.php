<link rel="stylesheet" href="{{ asset('svg.css') }}">
<aside id="logo-sidebar" class="px-3 pb-4 min-h-screen max-h-fit bg-white dark:bg-gray-800 w-64">
    <div class="px-3 pb-4 min-h-screen max-h-fit bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('home') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
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
                        <span class="flex-1 ml-3 whitespace-nowrap">Barang</span>
                        <svg class="openMenu"></svg>
                    </a>
                    <ul id="barangSubMenu"
                        class="hidden overflow-hidden transition-transform duration-300 bg-gray-500 rounded m-2 ">
                        <!-- Submenu for Barang -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('product.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Input
                                Barang</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('product.manage') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Manage
                                Barang</a>
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
                            <a href="{{ route('pesanan.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">List
                                Transaksi</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('pesanan.newOrder') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Buat
                                Pesanan Baru
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 4)
                <li class="stok">
                    <a href="{{ route('stok.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="stockIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Stok</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                <li class="user">
                    <a href="{{ route('manage.user.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
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
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
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
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Input
                                Gudang</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('gudang.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Manage
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
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Input
                                Company</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('company.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Manage
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
                        <li <!-- Submenu for Barang -->
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('branch.create') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Input
                                Branch</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('branch.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Manage
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
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Input
                                Customer</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('customer.index') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Manage
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
                        <svg class="customerIcon"></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Laporan</span>
                        <svg class="submenuOption"></svg>
                    </a>
                    <ul id="laporanSubMenu"
                        class="hidden overflow-hidden transition-max-height duration-300 ease-in-out bg-gray-500 rounded m-2 ">
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.stock') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Stok</a>
                        </li>
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('laporan.penjualan') }}"
                                class="pl-5 block py-2 text-gray-700 hover:text-dark dark:text-white dark:hover:text-black ">Penjualan</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    id="logout-button">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 "
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

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
