@extends('layouts')

@section('content')
    <div class="judul container m-auto mt-20 flex justify-start items-center gap-5 px-2 md:px-0">
        <div x-data>
            <button class="rollback text-white p-2 rounded-full w-10 h-10 z-10 text-lg" @click="window.history.back()">
                &#10094;
            </button>
        </div>
        <h1 class="judul-hero text-white text-xl sm:text-2xl md:text-left">
            {{ $genre->title }}
        </h1>
    </div>

    <div
        class="con container m-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5 mt-10 px-2 md:px-0">
        @if ($films->isEmpty())
            <p class="text-white text-center col-span-full h-pencarian">Tidak ada film yang tersedia.</p>
        @else
            @foreach ($films as $film)
                <a href="{{ route('detail-film', ['id' => $film->id]) }}" class="film-card block relative">
                    <div class="img-wrapper">
                        <img src="{{ asset('storage/assets/' . $film->poster) }}" class="rounded-lg shadow-lg"
                            alt="{{ $film->title }}">
                    </div>
                    <h1 class="text-white text-md">{{ $film->title }}</h1>
                </a>
            @endforeach
        @endif
    </div>
    </div>

    <style>
        .con {
            min-height: 57vh;
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
    </style>

@endsection
