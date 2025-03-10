<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MoviesKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Font Family --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Swiper --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <section>
        @yield('styles')
    </section>
</head>

<body class="bg-black ">
    {{-- Navbar Start --}}
    <nav class=" bg-black z-50 fixed top-0 left-0 w-full" x-data="{ mobileMenuOpen: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 0">
        <div :class="scrolled ? 'bg-black' : 'bg-transparent'" class="transition-colors duration-300 mx-auto container">
            <div class="relative flex h-16 items-center">
                <!-- Mobile menu button -->
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen.toString()">
                        <span class="sr-only">Open main menu</span>
                        <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="block size-6"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg :class="{ 'hidden': !mobileMenuOpen, 'block': mobileMenuOpen }" class="hidden size-6"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center ml-12 sm:ml-0">
                    <a href="#">
                        <h2 class="logo text-blue-600 text-2xl font-black"><i class="fa-regular fa-circle-play"></i>
                            <span class="text-2xl font-bold">Movies</span><span
                                class="text-2xl font-bold text-blue-800">Ku</span>
                        </h2>
                    </a>
                </div>

                <!-- Navigation Menu (Center) -->
                <div class="flex-1 flex justify-center">
                    <div class="nav-menu hidden">
                        <div class="flex space-x-2">
                            <a href="{{ route('dashboard') }}"
                                class="rounded-md px-3 py-2 text-sm font-medium
                                {{ Route::is('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}"
                                aria-current="page">
                                Home
                            </a>
                            <a href="{{ route('semua-film') }}"
                                class="rounded-md px-3 py-2 text-sm font-medium
                                {{ Route::is('semua-film') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Film
                            </a>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        {{-- Profile Button --}}
                        <button @click="open = !open" type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent leading-4 font-medium rounded-md text-neutral-500 dark:text-neutral-400 bg-transparent hover:text-neutral-700 dark:hover:text-neutral-300 focus:outline-none transition ease-in-out duration-150">
                            <span class="text-gray-300 text-sm">{{ Auth::user()->name }}</span>
                            <div class="ms-3">
                                @php
                                    $user = Auth::user();
                                    $avatar = $user->avatar
                                        ? Storage::url($user->avatar)
                                        : asset('storage/avatars/default-avatar.png');
                                @endphp
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $avatar }}"
                                    alt="{{ $user->name }}'s Avatar">
                            </div>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-2">
                                {{-- Profile Link --}}
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-8 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Profile
                                </a>

                                {{-- Admin & Author Dashboard Link --}}
                                @php
                                    $dashboardRoute =
                                        Auth::user()->role === 'admin'
                                            ? 'admin.dashboard.index'
                                            : 'author.dashboard.index';
                                @endphp

                                @if (in_array(Auth::user()->role, ['admin', 'author']))
                                    <a href="{{ route($dashboardRoute) }}"
                                        class="block px-8 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Dashboard
                                    </a>
                                @endif

                                {{-- Logout Form --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-8 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth



                @guest
                    <div class="flex sm:flex items-center">
                        <a href="{{ route('login') }}"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-1.5 md:py-2 mb-2 mt-2 me-2 md:me-2 focus:outline-none">Login</a>
                        <a href="{{ route('register') }}"
                            class="hidden text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-sm px-5 py-1.5 md:py-2 me-2 mt-2 md:me-0 mb-2">Register</a>
                    </div>
                @endguest

            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-transition class="sm:hidden bg-black">
            <div class="space-y-1 px-4 pb-3 pt-2">
                <a href="#"
                    class="block rounded-md bg-gray-900 px-4 py-2 text-base font-medium text-white">Home</a>
                <a href="#"
                    class="block rounded-md px-4 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Movies</a>
                <a href="#"
                    class="block rounded-md px-4 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">More</a>
            </div>
        </div>
    </nav>
    {{-- Navbar End --}}

    <section class="">
        @yield('content')
    </section>

    <!-- Footer container -->
    <footer class="bg-white mt-20 shadow-sm m-4 dark:bg-gray-800">
        <div class="container m-auto py-4 md:flex md:items-center md:justify-between px-2 md:px-0">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="#"
                    class="hover:underline">MoviesKu™</a>. All Rights Reserved.
            </span>
            <ul
                class="flex flex-wrap items-center gap-4 md:gap-6 mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                <li>
                    <a href="#" class="hover:underline mr-4 md:pr-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline mr-4 md:pr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline mr-4 md:pr-6">Film</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
    </footer>

</body>

</html>
