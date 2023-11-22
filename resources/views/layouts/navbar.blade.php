<!-- Main navigation container -->
<nav
    class="fixed top-0 z-50 flex-no-wrap flex w-full items-center justify-between py-2 shadow-md shadow-black/5 dark:bg-gray-800 dark:shadow-black/10 lg:flex-wrap lg:justify-start lg:py-4">
    <div class="flex w-full flex-wrap items-center justify-between px-3">
        <!-- Hamburger button for mobile view -->
        <button
            class="block border-0 bg-transparent px-2 text-neutral-500 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
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
            <a class="mb-4 ml-2 mr-5 mt-3 flex items-center text-neutral-900 hover:text-neutral-900 focus:text-neutral-900 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 lg:mb-0 lg:mt-0"
                href="#">
                <img src="{{ asset('images/dashboard/logo_1.png') }}" style="height: 15px" alt="BULOG"
                    loading="lazy" />
            </a>
            <!-- Left navigation links -->
            <ul class="list-style-none mr-auto flex flex-col pl-0 lg:flex-row" data-te-navbar-nav-ref>
                <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                    <!-- Dashboard link -->
                    <a class="text-neutral-500 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 lg:px-2 [&.active]:text-black/90 dark:[&.active]:text-zinc-400"
                        href="{{route('home')}}" data-te-nav-link-ref>
                        <i class="fa-solid fa-home"></i>
                        Home
                    </a>
                </li>
            </ul>
        </div>

        <!-- Right elements -->
        <div class="relative flex items-center">

            <!-- Container with two dropdown menus -->
            <div class="relative" data-te-dropdown-ref data-te-dropdown-alignment="end">
                <!-- First dropdown trigger -->
                <a class="hidden-arrow mr-4 flex items-center text-neutral-600 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 [&.active]:text-black/90 dark:[&.active]:text-neutral-400"
                    href="#" id="dropdownMenuButton1" role="button" data-te-dropdown-toggle-ref
                    aria-expanded="false">
                    <!-- Dropdown trigger icon -->
                    <i class="fa-solid fa-bell"></i>
                    <!-- Notification counter -->
                    <span
                        class="absolute -mt-4 ml-2.5 rounded-full bg-danger px-[0.35em] py-[0.15em] text-[0.6rem] font-bold leading-none text-white">
                        0
                    </span>
                </a>
                <!-- First dropdown menu -->
                <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                    aria-labelledby="dropdownMenuButton1" data-te-dropdown-menu-ref style="right: 0;">
                    <!-- First dropdown menu items -->
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref>
                            Action
                        </a>
                    </li>
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref>
                            Another action
                        </a>
                    </li>
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref>
                            Something else here
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Second dropdown container -->
            <div class="relative" data-te-dropdown-ref data-te-dropdown-alignment="end">
                <!-- Second dropdown trigger -->
                <a class="hidden-arrow flex items-center whitespace-nowrap transition duration-150 ease-in-out motion-reduce:transition-none"
                    href="#" id="dropdownMenuButton2" role="button" data-te-dropdown-toggle-ref
                    aria-expanded="false">
                    <!-- User avatar -->
                    <small class="px-2 ml-2 text-white">{{Auth::user()->name}}</small>
                    <img src="https://tecdn.b-cdn.net/img/new/avatars/2.jpg" class="rounded-full"
                        style="height: 25px; width: 25px" alt="" loading="lazy" />
                </a>
                <!-- Second dropdown menu -->
                <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                aria-labelledby="dropdownMenuButton2" data-te-dropdown-menu-ref="avatarDropdown" style="right: 0;">
                    <!-- Dropdown menu items -->
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref>
                            <i class="fa-solid fa-user px-1"></i>
                            My Account
                        </a>
                    </li>
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref>
                            <i class="fa-solid fa-circle-info px-1"></i>
                            Information
                        </a>
                    </li>
                    <hr>
                    <li>
                        <a class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                            href="#" data-te-dropdown-item-ref id="logout-button">
                            <i class="fa-solid fa-arrow-right-from-bracket px-1"></i>
                            Log Out
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
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
        // Get the notification button and dropdown menu
        var notificationButton = document.getElementById('dropdownMenuButton1');
        var notificationDropdown = document.querySelector('[data-te-dropdown-menu-ref]');

        // Add a click event listener to the notification button
        notificationButton.addEventListener('click', function(event) {
            // Prevent the default behavior (e.g., following the link)
            event.preventDefault();

            // Toggle the visibility of the notification dropdown
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

        avatarButton.addEventListener('click', function (event) {
            event.preventDefault();
            avatarDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!avatarButton.contains(event.target) && !avatarDropdown.contains(event.target)) {
                avatarDropdown.classList.add('hidden');
            }
        });
    });
</script>
