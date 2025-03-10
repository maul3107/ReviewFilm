@extends('layouts')

@section('content')
    {{-- Hero Start --}}
    <!-- Swiper -->
    <div class="swiper mySwiper h-screen">
        <div class="swiper-wrapper">
            @foreach ($heroFilms as $heroFilm)
                <div class="swiper-slide flex justify-center items-center">
                    <div
                        class="flex flex-col-reverse md:flex-row items-center justify-center lg:justify-between h-screen gap-5 md:gap-10 pt-16 container m-auto">
                        <!-- Left Section: Hero Text -->
                        <div
                            class="hero-text lg:max-w-2xl text-center md:text-left mb-8 lg:mb-0 md:max-w-sm flex flex-col justify-center items-center md:items-start">
                            <h1 class="judul-hero text-white text-2xl md:text-4xl sm:text-3xl md:text-left">
                                {{ $heroFilm->title }}
                            </h1>
                            <p class="text-gray-300 my-4 text-md md:text-lg md:text-left">
                                {{ $heroFilm->description }}
                            </p>
                            <div class="flex items-center justify-center sm:justify-center md:justify-normal">
                                <a href="{{ $heroFilm->trailer_url }}" target="_blank"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                                    Watch Trailer <i class="fa-solid fa-circle-play"></i>
                                </a>
                                <a href="{{ route('detail-film', $heroFilm->id) }}"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-md text-sm px-5 py-2.5 me-2 mb-2">
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
    {{-- Hero End --}}
    {{-- Movie Start --}}
    <div class="container m-auto mt-20 px-2">
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
                            <a href="{{ route('detail-film', $film->id) }}" class="film-card block">
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
    </style>
@endsection
