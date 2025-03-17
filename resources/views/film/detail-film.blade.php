@extends('layouts')

@section('content')
    <div class="min-h-screen">
        {{-- Card Start --}}
        <div class="bg relative p-2 md:p-8 mt-16">
            <div class="container m-auto flex justify-start items-center flex-col md:flex-row gap-8">
                <div class="flex-none size-full md:w-60">
                    <img src="{{ asset('storage/assets/' . $film->poster) }}" alt="{{ $film->title }}"
                        class="rounded-lg shadow-lg">
                </div>
                <div class="flex-1 max-w-3xl">
                    <h1 class="text-3xl text-white">{{ $film->title }}</h1>
                    <div class="director">
                        <h2 class="text-gray-300">Director By <span class="font-bold">{{ $film->creator }}</span></h2>
                    </div>
                    <div class="my-5">
                        @foreach ($film->genres as $genre)
                            <span class="bg-gray-200 text-sm px-4 py-1 rounded-full mr-2">{{ $genre->title }}</span>
                        @endforeach
                    </div>
                    <p class="font-light text-white text-md leading-relaxed my-4">
                        {{ $film->description }}
                    </p>
                    <div class="flex items-center gap-3 my-3">
                        <div>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($filteredAverage))
                                    <span class="fa fa-star text-yellow-400"></span>
                                @elseif ($i == ceil($filteredAverage) && $filteredAverage - floor($filteredAverage) >= 0.5)
                                    <span class="fa fa-star-half-alt text-yellow-400"></span>
                                @else
                                    <span class="fa fa-star text-gray-400"></span>
                                @endif
                            @endfor
                        </div>
                        <p class="text-lg">
                            <span class="text-sm text-white">{{ number_format($filteredAverage, 1) }} </span>
                            <span class="text-sm text-gray-400">({{ $filteredNumberOfComments }} rates)</span>
                        </p>
                    </div>

                    <!-- Trailer button with x-data directive -->
                    <div x-data="trailer()">
                        <button @click="playTrailer('{{ Illuminate\Support\Str::afterLast($film->trailer, '/') }}')"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-md text-sm px-5 py-2.5">
                            Watch Trailer <i class="fa-solid fa-circle-play"></i>
                        </button>
                        <!-- Trailer Popup -->
                        <div x-show="showTrailer" x-cloak x-transition.opacity.duration.300ms @click.self="closeTrailer()"
                            @keydown.window.escape="closeTrailer()"
                            class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50">
                            <div class="relative w-full max-w-3xl bg-gray-800 rounded-lg shadow-lg">
                                <button @click="closeTrailer()"
                                    class="absolute top-2 right-2 text-white text-2xl z-10 cursor-pointer">
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

                </div>
            </div>
        </div>
        {{-- Card End --}}

        {{-- Castings Start --}}
        <div class="container m-auto mt-16 px-3 md:px-0">
            <h1 class="text-2xl text-white text-left">Castings</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-5 sm:px-1">
                @foreach ($film->castings as $actor)
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $actor->photo) }}" class="w-16 h-16 rounded-full object-cover"
                            alt="{{ $actor->real_name }}">
                        <div>
                            <p class="text-gray-400 text-sm">Cast</p>
                            <p class="font-semibold text-white">{{ $actor->real_name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Castings End --}}

        <!-- Comment Section Start -->
        <div class="container m-auto mt-16 px-3 md:px-0">
            @php
                $userComment = $film->comments->where('user_id', auth()->id())->first();
            @endphp

            <div x-data="{ openCommentModal: false, openAllComment: false }">
                <div class="flex justify-between items-center flex-wrap">
                    <div class="flex justify-center items-center gap-5">
                        <h1 class="text-2xl text-white">Rating dan Ulasan</h1>
                        <div @click="openAllComment = true" class="cursor-pointer text-gray-300 text-xl"><i
                                class="fa-solid fa-arrow-right"></i>
                        </div>
                    </div>
                </div>

                <!-- Modal Popup untuk all komentar & rating -->
                <div x-show="openAllComment"
                    class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak
                    x-data="{
                        sortBy: 'relevant',
                        ratingFilter: 'all',
                        currentComment: null
                    }" @keydown.window.escape="openAllComment = false" x-init="$watch('openAllComment', value => {
                        if (value) {
                            document.body.classList.add('overflow-hidden');
                        } else {
                            document.body.classList.remove('overflow-hidden');
                        }
                    })">
                    <div class="section-allcoment bg-gray-900 p-6 rounded-lg w-full max-w-3xl max-h-[90vh] flex flex-col shadow-lg relative"
                        @click.away="openAllComment = false">

                        <!-- Tombol Close -->
                        <button @click="openAllComment = false"
                            class="absolute text-gray-400 hover:text-white text-3xl font-bold z-50 transition-colors duration-200"
                            style="top: 1rem; right: 1rem;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Header -->
                        <div class="flex items-center space-x-3 flex-shrink-0">
                            <img src="{{ asset('storage/assets/' . $film->poster) }}"
                                class="w-16 h-16 rounded-lg object-cover" alt="{{ $film->title }}">
                            <div>
                                <h2 class="text-white font-semibold text-2xl">{{ $film->title }}</h2>
                                <p class="text-gray-400 text-md">Rating dan ulasan</p>
                            </div>
                        </div>

                        <!-- Filter dan Rating -->
                        <div class="flex gap-3 mt-6 flex-shrink-0">
                            <!-- Rating Filter -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="bg-gray-800 text-white px-8 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition-colors">
                                    <span
                                        x-text="ratingFilter === 'all' ? 'Semua Rating' : ratingFilter + ' Bintang'"></span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute z-50 top-full left-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg py-2">
                                    <button @click="ratingFilter = 'all'; open = false"
                                        class="w-full px-4 py-2 text-left text-white hover:bg-gray-700">
                                        Semua Rating
                                    </button>
                                    <template x-for="rating in [5,4,3,2,1]">
                                        <button @click="ratingFilter = rating; open = false"
                                            class="w-full px-4 py-2 text-left text-white hover:bg-gray-700"
                                            x-text="rating + ' Bintang'">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Scrollable Comments Section -->
                        <div class="comment-scroll flex-1 overflow-y-auto mt-4 space-y-4 pr-2">
                            <!-- Bagian untuk menampilkan tiap komentar -->
                            @foreach ($film->comments as $comment)
                                <div x-show="(ratingFilter === 'all') || (ratingFilter === {{ $comment->rating }} && '{{ $comment->user->role }}' !== 'admin' && '{{ $comment->user->role }}' !== 'author')"
                                    class="bg-gray-800 rounded-lg p-4 transition-all hover:bg-gray-750"
                                    x-data="{ editing: false, openMenu: false }">
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                                <img src="{{ isset($comment->user->avatar) ? asset('storage/' . $comment->user->avatar) : asset('storage/avatars/default-avatar.png') }}"
                                                    alt="User Avatar" class="w-full h-full object-cover">
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex items-center gap-2">
                                                    <p class="text-white font-semibold">{{ $comment->user->name }}</p>
                                                    @if ($comment->user->role === 'admin')
                                                        <span
                                                            class="px-2 py-1 text-xs bg-red-500 bg-opacity-30 text-red-700 rounded-lg">Admin</span>
                                                    @elseif($comment->user->role === 'author')
                                                        <span
                                                            class="px-2 py-1 text-xs bg-blue-500 bg-opacity-30 text-blue-700 rounded-lg">Author</span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-400 text-sm">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>

                                        @if (auth()->id() === $comment->user_id)
                                            <div class="relative">
                                                <button @click="openMenu = !openMenu"
                                                    class="text-gray-300 hover:text-white">&#x22EE;</button>
                                                <div x-show="openMenu" @click.away="openMenu = false"
                                                    class="absolute right-0 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-md shadow-lg p-2 z-10">
                                                    <button @click="editing = true; openMenu = false"
                                                        class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700 rounded-md">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('delete-comment', $comment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-700 rounded-md"
                                                            onclick="return confirm('Hapus komentar ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div x-show="!editing">
                                        @if ($comment->user->role !== 'admin' && $comment->user->role !== 'author')
                                            <div class="flex items-center mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="fa fa-star {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-400' }}"></span>
                                                @endfor
                                            </div>
                                        @endif
                                        <p class="text-gray-300 text-sm">{{ $comment->comment }}</p>
                                    </div>

                                    <div x-show="editing">
                                        <form action="{{ route('update-comment', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-2">
                                                <label class="text-gray-400 block mb-1">Rating</label>
                                                <div class="flex space-x-1 text-yellow-400 cursor-pointer"
                                                    x-data="{ rating: {{ $comment->rating }} }">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg @click="rating = {{ $i }}; $refs.editRatingInput.value = {{ $i }}"
                                                            :class="{
                                                                'text-yellow-500': rating >= {{ $i }},
                                                                'text-gray-600': rating < {{ $i }}
                                                            }"
                                                            class="w-8 h-8 transition duration-200 ease-in-out"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.4 4.298h4.516c.967 0 1.37 1.24.588 1.81l-3.658 2.641 1.4 4.297c.3.92-.755 1.688-1.54 1.1L10 14.347l-3.657 2.641c-.784.588-1.84-.18-1.54-1.1l1.4-4.297-3.658-2.641c-.782-.57-.38-1.81.588-1.81h4.516l1.4-4.298z" />
                                                        </svg>
                                                    @endfor
                                                    <input type="hidden" x-ref="editRatingInput" name="rating"
                                                        value="{{ $comment->rating }}">
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="text-gray-400 block mb-1">Komentar</label>
                                                <textarea name="comment"
                                                    class="w-full p-3 rounded-md bg-gray-800 text-white border border-gray-700 focus:ring focus:ring-blue-500 transition"
                                                    required>{{ $comment->comment }}</textarea>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="editing = false"
                                                    class="px-4 py-2 bg-gray-600 text-white rounded-md">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <!-- Comment Input Section -->
                        @auth
                            @if (!$userComment)
                                <form action="{{ route('store-comment') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="film_id" value="{{ $film->id }}">
                                    <div class="relative p-3 bg-gray-800 rounded-lg flex flex-col md:flex-row items-center flex-shrink-0"
                                        x-data="{ rating: 0 }">
                                        <!-- Rating -->
                                        <div class="flex items-center space-x-2 mb-3 md:mb-0 md:mr-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg @click="rating = {{ $i }}; $refs.ratingInput.value = {{ $i }}"
                                                    :class="{
                                                        'text-yellow-500': rating >= {{ $i }},
                                                        'text-gray-600': rating < {{ $i }}
                                                    }"
                                                    class="w-6 h-6 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.4 4.298h4.516c.967 0 1.37 1.24.588 1.81l-3.658 2.641 1.4 4.297c.3.92-.755 1.688-1.54 1.1L10 14.347l-3.657 2.641c-.784.588-1.84-.18-1.54-1.1l1.4-4.297-3.658-2.641c-.782-.57-.38-1.81.588-1.81h4.516l1.4-4.298z" />
                                                </svg>
                                            @endfor
                                            <input type="hidden" x-ref="ratingInput" name="rating" required>
                                        </div>
                                        <!-- Input Pesan & Tombol -->
                                        <div class="w-full flex items-center space-x-2">
                                            <input type="text" name="comment" placeholder="Ketik pesan"
                                                class="flex-grow bg-transparent focus:outline-none text-white placeholder-gray-400 px-4 py-2"
                                                required />
                                            <button type="submit" class="text-white hover:text-blue-500 transition-colors">
                                                <svg style="transform: rotate(90deg) !important;" class="w-6 h-6"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M12 2a1 1 0 0 1 .932.638l7 18a1 1 0 0 1-1.326 1.281L13 19.517V13a1 1 0 1 0-2 0v6.517l-5.606 2.402a1 1 0 0 1-1.326-1.281l7-18A1 1 0 0 1 12 2Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endauth

                    </div>
                </div>
            </div>
            <div class="mt-5">
                @foreach ($commentsNew as $comment)
                    <div class="mb-8" x-data="{ editing: false, openMenu: false }">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden">
                                    <img src="{{ isset($comment->user->avatar) ? asset('storage/' . $comment->user->avatar) : asset('storage/avatars/default-avatar.png') }}"
                                        alt="User Avatar" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-3">
                                    <div class="flex items-center gap-2">
                                        <p class="text-white font-semibold">{{ $comment->user->name }}</p>
                                        @if ($comment->user->role === 'admin')
                                            <span
                                                class="px-2 py-1 text-xs bg-red-500 bg-opacity-30 text-red-700 rounded-lg">Admin</span>
                                        @elseif($comment->user->role === 'author')
                                            <span
                                                class="px-2 py-1 text-xs bg-blue-500 bg-opacity-30 text-blue-700 rounded-lg">Author</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if (auth()->id() === $comment->user_id)
                                <div class="relative">
                                    <button @click="openMenu = !openMenu" class="text-gray-300 hover:text-white">
                                        &#x22EE;
                                    </button>
                                    <div x-show="openMenu" @click.away="openMenu = false"
                                        class="absolute right-0 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-md shadow-lg p-2 z-10">
                                        <button @click="editing = true; openMenu = false"
                                            class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700 rounded-md">Edit</button>
                                        <form action="{{ route('delete-comment', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-700 rounded-md"
                                                onclick="return confirm('Hapus komentar ini?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div x-show="!editing">
                            @if ($comment->user->role !== 'admin' && $comment->user->role !== 'author')
                                <div class="flex items-center mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span
                                            class="fa fa-star {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-400' }}"></span>
                                    @endfor
                                </div>
                            @endif
                            <p class="text-gray-300 text-sm">{{ $comment->comment }}</p>
                        </div>


                        <div x-show="editing">
                            <form action="{{ route('update-comment', $comment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-2">
                                    <label class="text-gray-400 block mb-1">Rating</label>
                                    <div class="flex space-x-1 text-yellow-400 cursor-pointer" x-data="{ rating: {{ $comment->rating }} }">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg @click="rating = {{ $i }}; $refs.editRatingInput.value = {{ $i }}"
                                                :class="{
                                                    'text-yellow-500': rating >=
                                                        {{ $i }},
                                                    'text-gray-600': rating < {{ $i }}
                                                }"
                                                class="w-8 h-8 transition duration-200 ease-in-out" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.4 4.298h4.516c.967 0 1.37 1.24.588 1.81l-3.658 2.641 1.4 4.297c.3.92-.755 1.688-1.54 1.1L10 14.347l-3.657 2.641c-.784.588-1.84-.18-1.54-1.1l1.4-4.297-3.658-2.641c-.782-.57-.38-1.81.588-1.81h4.516l1.4-4.298z" />
                                            </svg>
                                        @endfor
                                        <input type="hidden" x-ref="editRatingInput" name="rating"
                                            value="{{ $comment->rating }}">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="text-gray-400 block mb-1">Komentar</label>
                                    <textarea name="comment"
                                        class="w-full p-3 rounded-md bg-gray-800 text-white border border-gray-700 focus:ring focus:ring-blue-500 transition"
                                        required>{{ $comment->comment }}</textarea>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="editing = false"
                                        class="px-4 py-2 bg-gray-600 text-white rounded-md">Batal</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Comment Section End -->
    {{-- Random Films Section Start --}}
    <div class="container m-auto mt-16 px-3 md:px-0 mb-16">
        <h1 class="text-2xl text-white text-left mb-6">Film Lainnya</h1>

        <div class="relative">
            <div class="swiper mySwiperMovie">
                <div class="swiper-wrapper">
                    @foreach ($randomFilms as $randomFilm)
                        <div class="swiper-slide w-full">
                            <a href="{{ route('detail-film', $randomFilm->id) }}" class="film-card block">
                                <div class="img-wrapper">
                                    <img src="{{ asset('storage/assets/' . $randomFilm->poster) }}"
                                        class="rounded-lg shadow-lg" alt="{{ $randomFilm->title }}">
                                    <h1 class="text-white text-md">{{ $randomFilm->title }}</h1>
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
    {{-- Random Films Section End --}}
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
        function trailer() {
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
        .bg {
            background-image: url("{{ asset('storage/assets/' . $film->poster) }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 0;
        }

        .bg>* {
            position: relative;
            z-index: 1;
        }

        [x-cloak] {
            display: none !important;
        }

        .section-allcoment {
            max-height: 90vh;
        }

        .comment-scroll {
            min-height: 370px;
        }

        .comment-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Add these styles to your existing style section */
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
