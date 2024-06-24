<!-- Main navigation container -->
<nav
    class="fixed top-0 z-50 flex-no-wrap flex w-full items-center justify-between py-2 shadow-md shadow-black/5 bg-gray-800 shadow-black/10 lg:flex-wrap lg:justify-start lg:py-4 bg-bluelog">
    <div class="flex w-full flex-wrap items-center justify-between px-3">
        <!-- Hamburger button for mobile view -->
        <button
            class="block border-0 bg-transparent px-2 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
            type="button" data-te-collapse-init data-te-target="#navbarSupportedContent1"
            aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Hamburger icon -->
            <span class="[&>svg]:w-7">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                    <path fill-rule="evenodd"
                        d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        </button>

        <!-- Collapsible navigation container -->
        <div class="!visible hidden flex-grow basis-[100%] items-center lg:!flex lg:basis-auto"
            id="navbarSupportedContent1" data-te-collapse-item>
            <!-- Logo -->
            <a class="mb-4 ml-2 mr-5 mt-3 flex items-center lg:mb-0 lg:mt-0" href="{{ route('home') }}">
                <img src="{{ asset('images/dashboard/Logo_BULOG_putih.png') }}" style="height: 15px" alt="BULOG"
                    loading="lazy" />
            </a>

            <!-- Left navigation links -->
            {{-- <ul class="list-style-none mr-auto flex flex-col pl-0 lg:flex-row" data-te-navbar-nav-ref>
                <li class="mb-4  lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                    <!-- Dashboard link -->
                    <a class="text-neutral-500 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none text-neutral-200 hover:text-neutral-300 focus:text-neutral-300 lg:px-2 [&.active]:text-black/90 [&.active]:text-zinc-400"
                        href="{{ route('home') }}" data-te-nav-link-ref>
                        <i class="fa-solid fa-home mx-2"></i>
                        Beranda
                    </a>
                </li>
                <li class="mb-4  lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                    <div class="dropdown dropdown-bottom">
                        <div tabindex="0" role="button" class="text-white">Sync ERP</div>
                        <ul tabindex="0"
                            class="dropdown-content z-[1] menu p-2 shadow bg-gray-900 text-white rounded-box w-52">
                            <li><a href="{{ route('odoo.sync.import') }}" class="hover:bg-gray-800">Sync All From
                                    ERP</a></li>
                            <li><a href="{{ route('odoo.sync.debug') }}" class="hover:bg-gray-800">Sync Debug</a></li>
                        </ul>
                    </div>
                </li>
            </ul> --}}
        </div>

        <!-- Right elements -->
        <div class="relative flex items-center">


            <!-- Container with two dropdown menus -->
            <div class="relative" data-te-dropdown-ref data-te-dropdown-alignment="end">


                <p class="px-2 ml-2 text-neutral-50">{{ Auth::user()->name }}</p>

            </div>
            <button data-toggle-theme="corporate,business" data-act-class="ACTIVECLASS" id="switchTheme">
                <span class="lightMode">☀️</span>
                <span class="darkMode">🌙</span>
            </button>

            <!-- Second dropdown container -->
            <div class="relative" data-te-dropdown-ref data-te-dropdown-alignment="end">
                <!-- Second dropdown trigger -->



                <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 text-neutral-200 hover:bg-white/30 dark:text-white"
                    href="#" data-te-dropdown-item-ref id="logout-button">
                    <i class="fa-solid fa-arrow-right-from-bracket px-1 "></i>
                    Log Out
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        /// hamburger menu
        var hamburgerButton = document.querySelector('[data-te-collapse-init]');
        var collapsibleContainer = document.getElementById('navbarSupportedContent1');
        hamburgerButton.addEventListener('click', function() {
            collapsibleContainer.classList.toggle('hidden');
        });

        ///notification dropdown
        var notificationButton = document.getElementById('dropdownMenuButton1');
        var notificationDropdown = document.querySelector('[data-te-dropdown-menu-ref="notifDropdown"]');

        notificationButton.addEventListener('click', function(event) {
            event.preventDefault();

            notificationDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function(event) {
            if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event
                    .target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        /// avatar dropdown
        var avatarButton = document.getElementById('dropdownMenuButton2');
        var avatarDropdown = document.querySelector('[data-te-dropdown-menu-ref="avatarDropdown"]');

        avatarButton.addEventListener('click', function(event) {
            event.preventDefault();
            avatarDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!avatarButton.contains(event.target) && !avatarDropdown.contains(event.target)) {
                avatarDropdown.classList.add('hidden');
            }
        });

        /// Sync dropdown
        // var syncButton = document.getElementById('syncButton');
        // var syncDropdown = document.querySelector('[data-te-dropdown-menu-ref="syncDropdown"]');

        // syncButton.addEventListener('click', function(event) {
        //     console.log('pressed sync dropdown');
        //     event.preventDefault();
        //     event.stopPropagation(); // Stop event propagation
        //     syncDropdown.classList.toggle('hidden');
        // });


        // document.addEventListener('click', function(event) {
        //     if (!syncButton.contains(event.target) && !syncDropdown.contains(event.target)) {
        //         console.log('pressed sync dropdown 2');
        //         syncDropdown.classList.add('hidden');
        //     }
        // });
    });
</script>
