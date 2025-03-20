@extends('layouts')

@section('content')
    <div class="judul container m-auto mt-20 flex justify-start items-center gap-5 px-3 md:px-0">
        <div x-data="searchFilms()" class="w-full">
            <form @submit.prevent="searchFilms()" class="relative flex flex-wrap items-center gap-2">
                @csrf
                <div x-data>
                    <button class="rollback text-white p-2 rounded-full w-10 h-10 z-10 text-lg"
                        @click="window.history.back()">
                        &#10094;
                    </button>
                </div>

                <div class="flex-1 relative">
                    <input type="text" x-model="query" @input.debounce.800ms="searchFilms"
                        class="block w-full p-4 ps-10 text-sm text-white border border-gray-700 rounded-full bg-gray-900 focus:ring-blue-900 focus:border-blue-900"
                        placeholder="Cari berdasarkan judul..." />

                    <!-- Tombol X untuk menghapus kata kunci -->
                    <button type="button"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-100 hover:text-gray-300"
                        @click="clearQuery()" x-show="query.length > 0" x-transition>
                        &#10005;
                    </button>
                </div>

                <select x-model="age" @change="searchFilms"
                    class="cursor-pointer border border-gray-700 p-3 rounded-full bg-gray-900 text-white">
                    <option value="">Pilih Usia</option>
                    <option value="13">13+</option>
                    <option value="17">17+</option>
                    <option value="21">21+</option>
                </select>

                @php
                    $years = \App\Models\Film::pluck('release_year')->unique()->sortDesc();
                @endphp

                <select x-model="year" @change="searchFilms"
                    class="cursor-pointer border border-gray-700 p-3 rounded-full bg-gray-900 text-white">
                    <option value="">Pilih Tahun</option>
                    @foreach ($years as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>


                <button type="button" @click="clearFilters()"
                    class="text-white bg-red-700 hover:bg-red-800 p-3 rounded-full text-sm"
                    x-show="query.length > 0 || age || year">
                    Reset Filter
                </button>
            </form>

            <!-- Menampilkan hasil pencarian -->
            <div class="min-h-screen" x-show="query.length > 0 || age || year">
                <template x-if="loading">
                    <div class="text-white text-center pt-5">
                        <p>Mencari film...</p>
                    </div>
                </template>

                <template x-if="!loading && results.length > 0">
                    <div>
                        <h2 class="text-white text-lg pt-5">Hasil Pencarian:</h2>
                        <div
                            class="container m-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5 mt-5">
                            <template x-for="film in results" :key="film.slug">
                                <a :href="'/film/' + film.slug" class="film-card block relative">
                                    <div class="img-wrapper">
                                        <img :src="'/storage/assets/' + film.poster" class="rounded-lg shadow-lg"
                                            :alt="film.title">
                                    </div>
                                    <h1 class="text-white text-md" x-text="film.title"></h1>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="!loading && (query.length > 0 || age || year) && results.length === 0">
                    <div class="text-white text-center mt-5">
                        <p>Tidak ditemukan film sesuai filter.</p>
                    </div>
                </template>
            </div>

            <!-- Menampilkan genre dan semua film jika pencarian kosong -->
            <div class="min-h-screen" x-show="query.length === 0 && !age && !year">
                {{-- Genre Start --}}
                <div class="judul container m-auto mt-10 px-3 md:px-0">
                    <h1 class="judul-hero text-white text-xl sm:text-2xl md:text-left">
                        Cari Genre Menarik Untuk Kamu
                    </h1>
                </div>
                <div class="container m-auto flex justify-start items-center flex-wrap gap-4 mt-5">
                    @foreach ($genres as $genre)
                        <div class="relative">
                            <a href="{{ route('detail-genre', ['slug' => $genre->slug]) }}" class="block">
                                <p class="text-white bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-full">
                                    {{ $genre->title }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{-- Genre End --}}

                {{-- Semua Film Start --}}
                <div class="judul container m-auto mt-10">
                    <h1 class="judul-hero text-white text-xl sm:text-2xl md:text-left">
                        Semua Kategori Film
                    </h1>
                </div>
                <div
                    class="container m-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5 mt-5">
                    @foreach ($films as $film)
                        <a href="{{ route('detail-film', $film->slug) }}" class="film-card block relative">
                            <div class="img-wrapper">
                                <img src="{{ asset('storage/assets/' . $film->poster) }}" class="rounded-lg shadow-lg"
                                    alt="{{ $film->title }}">
                            </div>
                            <h1 class="text-white text-md">{{ $film->title }}</h1>
                        </a>
                    @endforeach
                </div>
                {{-- Semua Film End --}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchFilms', () => ({
                query: '',
                age: '',
                year: '',
                results: [],
                loading: false,

                // Melakukan pencarian film
                async searchFilms() {
                    // Jika semua filter kosong, kosongkan hasil dan jangan lakukan request
                    if (!this.query && !this.age && !this.year) {
                        this.results = [];
                        return;
                    }

                    this.loading = true;
                    try {
                        // Membangun URL dengan parameter pencarian
                        let params = new URLSearchParams();
                        if (this.query) params.append('q', this.query);
                        if (this.age) params.append('age', this.age);
                        if (this.year) params.append('year', this.year);

                        const url = `/api/search?${params.toString()}`;
                        const response = await fetch(url);

                        if (!response.ok) {
                            throw new Error("Gagal mengambil data");
                        }

                        this.results = await response.json();
                    } catch (error) {
                        console.error("Error:", error);
                        this.results = [];
                    } finally {
                        this.loading = false;
                    }
                },

                // Menghapus kata kunci pencarian
                clearQuery() {
                    this.query = '';
                    this.searchFilms();
                },

                // Menghapus semua filter
                clearFilters() {
                    this.query = '';
                    this.age = '';
                    this.year = '';
                    this.results = [];
                }
            }));
        });
    </script>
    <style>
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
