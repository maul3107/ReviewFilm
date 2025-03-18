@extends('layouts')

@section('content')
    <!-- Hero Section -->
    <div x-data="heroSection()" class="relative">
        <div class="swiper mySwiper h-screen">
            <div class="swiper-wrapper">
                @foreach ($heroFilms as $heroFilm)
                    <div class="swiper-slide flex justify-center items-center">
                        <div
                            class="flex flex-col-reverse md:flex-row items-center justify-center lg:justify-between h-screen gap-5 md:gap-10 pt-16 container m-auto">
                            <!-- Left Section: Hero Text -->
                            <div class="hero-text lg:max-w-2xl text-center md:text-left mb-8 lg:mb-0 md:max-w-sm">
                                <h1 class="text-white text-2xl md:text-4xl sm:text-3xl">
                                    {{ $heroFilm->title }}
                                </h1>
                                <p class="text-gray-300 my-4 text-md md:text-lg">
                                    {{ $heroFilm->description }}
                                </p>
                                <div class="flex items-center justify-center md:justify-start">
                                    <button
                                        @click="playTrailer('{{ Illuminate\Support\Str::afterLast($heroFilm->trailer, '/') }}')"
                                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-md text-sm px-5 py-2.5">
                                        Watch Trailer <i class="fa-solid fa-circle-play"></i>
                                    </button>
                                    <a href="{{ route('detail-film', $heroFilm->slug) }}"
                                        class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-md text-sm px-5 py-2.5 ml-2">
                                        More Info
                                    </a>
                                </div>
                            </div>

                            <!-- Right Section: Hero Image -->
                            <div class="hero-img">
                                <img src="{{ asset('storage/assets/' . $heroFilm->poster) }}" alt="{{ $heroFilm->title }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Trailer Popup -->
        <div x-show="showTrailer" x-cloak x-transition.opacity.duration.300ms @click.self="closeTrailer()"
            @keydown.window.escape="closeTrailer()"
            class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50">
            <div class="relative w-full max-w-3xl bg-gray-800 rounded-lg shadow-lg">
                <button @click="closeTrailer()" class="absolute top-2 right-2 text-white text-2xl z-10 cursor-pointer">
                    &times;
                </button>
                <div class="relative pt-[56.25%]">
                    <iframe x-ref="trailerVideo" class="absolute top-0 left-0 w-full h-full rounded" :src="trailerUrl"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    {{-- Movie Start --}}
    <div class="container m-auto mt-20 px-2 sm:px-0">
        <div class="flex justify-between items-center mb-4">
            <h1 class="judul-hero text-white text-xl sm:text-2xl md:text-left">
                Film Terbaru
            </h1>
            <a href="{{ route('semua-film') }}" class="text-blue-500 text-sm">Selengkapnya</a>
        </div>

        <div class="relative">
            <div class="swiper mySwiperMovie">
                <div class="swiper-wrapper">
                    @foreach ($films as $film)
                        <div class="swiper-slide w-full">
                            <a href="{{ route('detail-film', $heroFilm->slug) }}" class="film-card block">
                                <div class="img-wrapper">
                                    <img src="{{ asset('storage/assets/' . $film->poster) }}" class="rounded-lg shadow-lg"
                                        alt="{{ $film->title }}">
                                    <h1 class="text-white text-md">{{ $film->title }}</h1>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination-movie"></div>
            </div>
            <button
                class="swiper-button-prev-movie absolute text-white p-2 rounded-full w-10 h-10 z-10 text-lg">&#10094;</button>
            <button
                class="swiper-button-next-movie absolute text-white p-2 rounded-full w-10 h-10 z-10 text-lg">&#10095;</button>
        </div>
    </div>
    {{-- Movie End --}}
    {{-- About Start --}}
    <div id="about" class="container m-auto py-20 px-2 sm:px-0 bg-gradient-to-b">
        <!-- Header Section with Animation -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="relative inline-block">
                <h1 class="relative px-7 py-4 text-blue-600 rounded-lg text-3xl sm:text-4xl font-bold">
                    Tentang Kami
                </h1>
            </div>
            <p class="text-gray-300 text-lg md:text-xl leading-relaxed font-light">
                Kami adalah platform yang menyediakan informasi film terbaru, trailer, dan ulasan menarik. Dengan koleksi
                film yang selalu diperbarui, kami memastikan Anda tidak ketinggalan tontonan terbaik.
            </p>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-800 mx-auto mt-8 rounded-full"></div>
        </div>

        <!-- Cards Section with Enhanced Design -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 mx-auto">
            <!-- Card 1 -->
            <div
                class="group flex flex-col items-center p-8 bg-gray-900 rounded-xl border border-gray-800 shadow-xl transform transition duration-300 hover:scale-105 hover:shadow-2xl hover:border-blue-500/50 text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-20 h-20 flex items-center justify-center mx-auto bg-blue-500/10 rounded-full mb-6 group-hover:bg-blue-500/20 transition-all duration-300">
                        <i
                            class="fa-solid fa-film text-4xl text-blue-500 group-hover:text-blue-400 transition-colors duration-300"></i>
                    </div>
                    <h2 class="text-white text-xl font-semibold mb-3">Koleksi Terbaru</h2>
                    <p class="text-gray-400 mt-2 text-base">Dapatkan update film terbaru yang sedang trending di seluruh
                        dunia.</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="group flex flex-col items-center p-8 bg-gray-900 rounded-xl border border-gray-800 shadow-xl transform transition duration-300 hover:scale-105 hover:shadow-2xl hover:border-yellow-500/50 text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-20 h-20 flex items-center justify-center mx-auto bg-yellow-500/10 rounded-full mb-6 group-hover:bg-yellow-500/20 transition-all duration-300">
                        <i
                            class="fa-solid fa-star text-4xl text-yellow-500 group-hover:text-yellow-400 transition-colors duration-300"></i>
                    </div>
                    <h2 class="text-white text-xl font-semibold mb-3">Ulasan Berkualitas</h2>
                    <p class="text-gray-400 mt-2 text-base">Baca review mendalam dari berbagai film pilihan terbaik.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="group flex flex-col items-center p-8 bg-gray-900 rounded-xl border border-gray-800 shadow-xl transform transition duration-300 hover:scale-105 hover:shadow-2xl hover:border-red-500/50 text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-red-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-20 h-20 flex items-center justify-center mx-auto bg-red-500/10 rounded-full mb-6 group-hover:bg-red-500/20 transition-all duration-300">
                        <i
                            class="fa-solid fa-video text-4xl text-red-500 group-hover:text-red-400 transition-colors duration-300"></i>
                    </div>
                    <h2 class="text-white text-xl font-semibold mb-3">Tonton Trailer</h2>
                    <p class="text-gray-400 mt-2 text-base">Lihat cuplikan sebelum memutuskan untuk menonton film.</p>
                </div>
            </div>
        </div>

        <!-- Additional Stats Section -->
        <div class="mt-20 mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 p-8 bg-gray-800/50 rounded-2xl border border-gray-700">
                <div class="text-center px-4 py-2">
                    <p
                        class="text-4xl font-bold bg-gradient-to-r from-blue-500 to-purple-800 text-transparent bg-clip-text">
                        {{ number_format($genreCount) }}+
                    </p>
                    <p class="text-gray-400 mt-1">Genre</p>
                </div>
                <div class="text-center px-4 py-2">
                    <p
                        class="text-4xl font-bold bg-gradient-to-r from-blue-500 to-purple-800 text-transparent bg-clip-text">
                        {{ number_format($filmCount) }}+
                    </p>
                    <p class="text-gray-400 mt-1">Review Film</p>
                </div>
                <div class="text-center px-4 py-2">
                    <p
                        class="text-4xl font-bold bg-gradient-to-r from-blue-500 to-purple-800 text-transparent bg-clip-text">
                        {{ number_format($userCount) }}+
                    </p>
                    <p class="text-gray-400 mt-1">Pengguna Aktif</p>
                </div>
            </div>
        </div>
    </div>
    {{-- About End --}}
    {{-- Video & Trailer Start --}}
    <div id="trailers" x-data="trailerSection()" class="container m-auto py-20 px-2 sm:px-0">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-blue-600">
                Video & Trailer
            </h1>
            <p class="text-gray-300 text-lg mt-2">
                Tonton trailer terbaru dan cuplikan film terbaik pilihan kami.
            </p>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-800 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Swiper Container -->
        <div class="relative">
            <div class="swiper mySwiperTrailer">
                <div class="swiper-wrapper">
                    @foreach ($trailers as $trailer)
                        <div class="swiper-slide">
                            <div class="video-card group relative cursor-pointer">
                                <!-- Thumbnail dengan ukuran yang responsif -->
                                <div
                                    class="relative w-full max-w-md h-auto aspect-video rounded-lg shadow-lg overflow-hidden flex items-center justify-center">
                                    @php
                                        $url = $trailer->trailer;
                                        $videoId = '';

                                        // Ekstrak video ID menggunakan regex
                                        if (
                                            preg_match(
                                                '/(?:youtube\.com\/(?:[^\/\n\s]+\/\s*(?:\w*\/)?|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                                                $url,
                                                $matches,
                                            )
                                        ) {
                                            $videoId = $matches[1];
                                        } else {
                                            // Jika regex gagal, gunakan metode string sebagai backup
                                            if (strpos($url, 'youtu.be/') !== false) {
                                                $videoId = substr($url, strpos($url, 'youtu.be/') + 9);
                                            } elseif (strpos($url, 'watch?v=') !== false) {
                                                $videoId = substr($url, strpos($url, 'watch?v=') + 8);
                                            } elseif (strpos($url, 'embed/') !== false) {
                                                $videoId = substr($url, strpos($url, 'embed/') + 6);
                                            } else {
                                                $videoId = $url;
                                            }

                                            // Hapus parameter tambahan
                                            if (strpos($videoId, '&') !== false) {
                                                $videoId = substr($videoId, 0, strpos($videoId, '&'));
                                            }
                                        }

                                        // Pastikan video ID valid (11 karakter)
                                        if (strlen($videoId) != 11) {
                                            $videoId = ''; // Jika ID tidak valid, kosongkan
                                        }
                                    @endphp

                                    @if ($videoId)
                                        <!-- Thumbnail -->
                                        <div class="w-full h-full bg-cover bg-center"
                                            style="background-image: url('https://i3.ytimg.com/vi/{{ $videoId }}/maxresdefault.jpg');">
                                        </div>
                                    @else
                                        <!-- Placeholder jika ID video tidak valid -->
                                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                            <i class="fa-solid fa-film text-4xl text-gray-400"></i>
                                        </div>
                                    @endif

                                    <!-- Play button overlay -->
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center transition-opacity duration-300">
                                        <button @click="playTrailer('{{ $videoId }}')"
                                            class="w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center bg-blue-600 bg-opacity-90 hover:bg-blue-700 rounded-full">
                                            <i class="fa-solid fa-play text-xl sm:text-3xl text-white"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Title -->
                                <p class="mt-2 text-center text-base sm:text-lg font-semibold text-white">
                                    {{ $trailer->title }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button
                class="swiper-button-prev-trailer absolute text-white p-2 rounded-full w-10 h-10 z-10 hidden sm:block">&#10094;</button>
            <button
                class="swiper-button-next-trailer absolute text-white p-2 rounded-full w-10 h-10 z-10 hidden sm:block">&#10095;</button>
        </div>

        <!-- Trailer Popup -->
        <div x-show="showTrailer" x-cloak x-transition.opacity.duration.300ms @click.self="closeTrailer()"
            @keydown.window.escape="closeTrailer()"
            class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50">
            <div class="relative w-full max-w-4xl bg-gray-800 rounded-lg shadow-lg">
                <button @click="closeTrailer()" class="absolute top-2 right-2 text-white text-2xl z-10 cursor-pointer">
                    &times;
                </button>
                <div class="relative pt-[56.25%]">
                    <iframe x-ref="trailerVideo" class="absolute top-0 left-0 w-full h-full rounded"
                        :src="trailerUrl" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    {{-- Video & Trailer End --}}
    <!-- Partner Kami Section -->
    <div id="partners" class="container m-auto py-20 px-2 sm:px-0">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-blue-600">Partner Kami</h1>
            <p class="text-gray-300 text-lg mt-2">Kami bekerja sama dengan berbagai platform dan studio ternama.</p>
            <div class="h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-800 mx-auto mt-4 rounded-full"></div>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 justify-items-center bg-gray-700/50 p-8 rounded-2xl border border-gray-700">
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2022/01/vidio-300x72.png" alt="Partner 1"
                    class="h-16 object-cover">
            </div>
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2023/10/wetv-1-300x72.png" alt="Partner 2"
                    class="h-16 object-cover">
            </div>
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2022/01/viu-300x72.png" alt="Partner 3"
                    class="h-16 object-cover">
            </div>
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2022/01/dana-300x72.png   " alt="Partner 4"
                    class="h-16 object-cover">
            </div>
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2022/01/cacthplay-300x72.png" alt="Partner 4"
                    class="h-16 object-cover">
            </div>
            <div class="partner-logo">
                <img src="https://asset.tix.id/wp-content/uploads/2022/01/cgv-300x72.png" alt="Partner 4"
                    class="h-16 object-cover">
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="container mx-auto py-20 px-4 sm:px-0 flex flex-col lg:flex-row items-center gap-12">

        <!-- Contact Info -->
        <div class="lg:w-1/2 text-center lg:text-left">
            <h1 class="text-3xl sm:text-4xl font-bold text-blue-600">Hubungi Kami</h1>
            <p class="text-gray-300 text-lg mt-2 mb-8">Kami siap membantu Anda! Jangan ragu untuk menghubungi kami.</p>
            <div class="mx-auto lg:ml-0 h-1 w-24 bg-gradient-to-r from-blue-500 to-purple-600 mb-8 rounded-full"></div>

            <div class="space-y-4 text-gray-300">
                <p class="flex items-center justify-center lg:justify-start gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <strong>Email:</strong> support@example.com
                </p>
                <p class="flex items-center justify-center lg:justify-start gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                        </path>
                    </svg>
                    <strong>Telepon:</strong> +62 812 3456 7890
                </p>
                <p class="flex items-center justify-center lg:justify-start gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <strong>Alamat:</strong> Jakarta, Indonesia
                </p>
            </div>

            <!-- Social Media -->
            <div class="mt-6 flex justify-center lg:justify-start gap-4">
                <a href="https://facebook.com" target="_blank" class="text-blue-500 hover:text-blue-700 transition">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 12a10 10 0 10-11.5 9.88V14.9H7.9V12h2.6V9.8a3.6 3.6 0 013.9-4c1.1 0 2.2.1 2.5.1v2.8h-1.7c-1.3 0-1.6.7-1.6 1.5V12h3l-.5 2.9h-2.5v6.98A10 10 0 0022 12z" />
                    </svg>
                </a>
                <a href="https://twitter.com" target="_blank" class="text-blue-400 hover:text-blue-600 transition">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.29 20c7.55 0 11.7-6.26 11.7-11.7v-.54a8.3 8.3 0 002-2.1 8.1 8.1 0 01-2.3.64A4.1 4.1 0 0021 4.6a8.2 8.2 0 01-2.6 1 4 4 0 00-6.8 3.6 11.3 11.3 0 01-8.2-4.1 4.1 4.1 0 001.2 5.5A4.1 4.1 0 012 9.7v.05a4 4 0 003.3 4 4 4 0 01-1.8.07 4 4 0 003.7 2.7A8.2 8.2 0 012 18a11.6 11.6 0 006.3 1.8" />
                    </svg>
                </a>
                <a href="https://instagram.com" target="_blank" class="text-pink-500 hover:text-pink-700 transition">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.5 2h9A5.5 5.5 0 0122 7.5v9A5.5 5.5 0 0116.5 22h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2zm4.5 5.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9zm6.5-.4a1 1 0 100 2 1 1 0 000-2zm-6.5 1.9a2.6 2.6 0 110 5.2 2.6 2.6 0 010-5.2z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Contact Form -->
        <div id="contact" class="lg:w-1/2 p-5 rounded-xl shadow-2xl w-full border border-gray-700">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="mb-4 p-4 text-green-700 bg-green-200 border border-green-500 rounded-lg">
                    {{ session('success') }}
                </div>

                <!-- JavaScript Redirect ke #contact -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        window.location.hash = 'contact';
                    });
                </script>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-300 text-lg font-medium mb-2" for="name">Nama</label>
                    <input name="name"
                        class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                        id="name" type="text" placeholder="Nama Anda" required>
                </div>
                <div>
                    <label class="block text-gray-300 text-lg font-medium mb-2" for="email">Email</label>
                    <input name="email"
                        class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                        id="email" type="email" placeholder="Email Anda" required>
                </div>
                <div>
                    <label class="block text-gray-300 text-lg font-medium mb-2" for="message">Pesan</label>
                    <textarea name="message"
                        class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-300"
                        id="message" rows="5" placeholder="Tulis pesan Anda..." required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition-transform transform hover:scale-105 hover:shadow-xl">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>


    </div>
    <!-- Add the trailer section Alpine.js script -->
    <script>
        // Trailer Section Alpine.js Component
        function trailerSection() {
            return {
                showTrailer: false,
                trailerUrl: '',
                playTrailer(videoId) {
                    this.trailerUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                    this.showTrailer = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeTrailer() {
                    this.showTrailer = false;
                    document.body.classList.remove('overflow-hidden');
                    this.$nextTick(() => {
                        this.trailerUrl = ''; // Reset video setelah popup tertutup
                    });
                }
            }
        }
    </script>


    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
    <script>
        var swiperTrailer = new Swiper(".mySwiperTrailer", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next-trailer",
                prevEl: ".swiper-button-prev-trailer",
            },
            breakpoints: {
                470: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
            },
        });
    </script>

    <script>
        var swiperMovie = new Swiper(".mySwiperMovie", {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next-movie",
                prevEl: ".swiper-button-prev-movie",
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
                1120: {
                    slidesPerView: 6,
                    spaceBetween: 20,
                },
            },
        });
    </script>
    <script>
        // Hero Section Alpine.js Component
        function heroSection() {
            return {
                showTrailer: false,
                trailerUrl: '',
                playTrailer(videoId) {
                    this.trailerUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                    this.showTrailer = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeTrailer() {
                    this.showTrailer = false;
                    document.body.classList.remove('overflow-hidden');
                    this.$nextTick(() => {
                        this.trailerUrl = ''; // Reset video setelah popup tertutup
                    });
                }
            }
        }
    </script>
@endsection

@section('styles')
    <style>
        h1 {
            font-weight: 600;
        }

        h2 {
            font-weight: 500;
        }

        .hero-img {
            width: 70%;
        }

        .swiper {
            width: 100%;
        }

        .mySwiperMovie {
            height: 330px;
        }

        .mySwiperMovie .swiper-slide {
            height: 220px !important;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-pagination-bullet {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .swiper-pagination-bullet-active {
            width: 40px;
            height: 7px;
            border-radius: 5px;
            background-color: #0066ff;
        }

        .swiper-button-disabled {
            background-color: #9292928a !important;
        }

        .swiper-button-prev-movie,
        .swiper-button-next-movie {
            background-color: #c5c5c5a1;
            top: 43%;
            transform: translateY(-50%);
        }

        .swiper-button-prev-movie {
            left: 8px;
        }

        .swiper-button-next-movie {
            right: 8px;
        }

        @media only screen and (min-width: 400px) {
            .hero-img {
                width: 100%;
            }
        }

        @media only screen and (min-width: 640px) {
            .judul-hero {
                line-height: 55px;
            }
        }

        @media only screen and (min-width: 1024px) {
            .swiper-pagination {
                position: absolute !important;
                bottom: 15% !important;
                left: 7% !important;
                display: flex;
                justify-content: flex-start;
                z-index: 10;
            }
        }

        .film-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            height: 20rem;
            /* Pastikan card memiliki tinggi tetap */
        }

        /* Wrapper untuk memastikan hanya gambar yang membesar */
        .film-card .img-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        /* Pastikan hanya gambar yang membesar */
        .film-card img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .film-card:hover img {
            transform: scale(1.1);
        }

        /* Overlay awalnya tidak terlihat */
        .film-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 0.5rem;
            opacity: 0;
            /* Default: tidak terlihat */
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        /* Overlay hanya muncul saat hover */
        .film-card:hover::after {
            opacity: 1;
        }

        /* Judul awalnya tidak terlihat */
        .film-card h1 {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            color: white;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Judul muncul saat hover */
        .film-card:hover h1 {
            opacity: 1;
        }

        .hero-img {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-img img {
            width: 100%;
            max-width: 400px;
            /* Maksimal 400px di layar besar */
            height: auto;
            /* Biarkan tinggi mengikuti lebar */
            aspect-ratio: 1 / 1;
            /* Menjaga gambar tetap berbentuk lingkaran */
            border-radius: 50%;
            /* Membuatnya bulat */
            object-fit: cover;
            /* Memastikan gambar tetap proporsional */
        }

        [x-cloak] {
            display: none !important;
        }

        .video-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
        }

        .video-card iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-card .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .video-card:hover .overlay {
            opacity: 1;
        }

        .swiper-button-prev-trailer,
        .swiper-button-next-trailer {
            background-color: rgba(255, 255, 255, 0.3);
            top: 43%;
            transform: translateY(-50%);
        }

        .swiper-button-prev-trailer {
            left: 8px;
        }

        .swiper-button-next-trailer {
            right: 8px;
            /* Pastikan tombol next ada di kanan */
        }
    </style>
@endsection
