@extends('layouts')

@section('content')

{{-- Card Start--}}
<div class="bg relative p-2 md:p-8 mt-16">
    <div class="container m-auto flex justify-start items-center flex-col md:flex-row gap-8">
        <div class="flex-none size-full md:w-60">
            <img src="{{ asset('storage/assets/' . $film->poster) }}" alt="{{ $film->title }}" class="rounded-lg shadow-lg">
        </div>
        <div class="flex-1 max-w-3xl">
            <h1 class="text-3xl text-white">{{ $film->title }}</h1>
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
                            <span class="fa fa-star text-yellow-400"></span> {{-- Bintang penuh --}}
                        @elseif ($i == ceil($filteredAverage) && $filteredAverage - floor($filteredAverage) >= 0.5)
                            <span class="fa fa-star-half-alt text-yellow-400"></span> {{-- Bintang setengah --}}
                        @else
                            <span class="fa fa-star text-gray-400"></span> {{-- Bintang kosong --}}
                        @endif
                    @endfor
                </div>
                <p class="text-lg">
                    <span class="text-sm text-white">{{ number_format($filteredAverage, 1) }} </span>
                    <span class="text-sm text-gray-400">({{ $filteredNumberOfComments }} rates)</span>
                </p>
            </div>

            <div class="flex justify-start items-center">
                <a
                    href="{{ $film->trailer_url }}" target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2 me-2 mb-2 focus:outline-none">
                    Watch Trailer <i class="fa-solid fa-circle-play"></i>
                </a>
                <span class="time-video text-sm ml-5 py-1.5 pl-5 mb-2 border-indigo-500 text-gray-200">{{ $film->duration }} menit</span>
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
                <img src="{{ asset('storage/' . $actor->photo) }}" class="w-16 h-16 rounded-full object-cover" alt="{{ $actor->stage_name }}">
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

    <div x-data="{ openCommentModal: false }">
        <div class="flex justify-between items-center flex-wrap gap-5">
            <h1 class="text-2xl text-white">Rating dan Ulasan</h1>
            @auth
            @if (!$userComment)
                <button @click="openCommentModal = true" class="px-4 py-2 bg-green-600 text-white rounded-md">
                    Tambah Rating dan Ulasan
                </button>
            @endif
            @endauth

        </div>
        <!-- Modal Popup untuk tambah komentar & rating -->
        <div x-show="openCommentModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak>
            <div class="bg-gray-900 p-6 rounded-lg w-full max-w-md shadow-lg relative">
                <h2 class="text-white text-xl font-semibold mb-4">Tambah Komentar & Rating</h2>

                <form action="{{ route('store-comment') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="film_id" value="{{ $film->id }}">

                    <!-- Star Rating -->
                    <div class="mb-2">
                        <label class="text-gray-400 block mb-1">Rating</label>
                        <div class="flex space-x-1 text-yellow-400 cursor-pointer" x-data="{ rating: 0 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg @click="rating = {{ $i }}; $refs.ratingInput.value = {{ $i }}"
                                    :class="{ 'text-yellow-500': rating >= {{ $i }}, 'text-gray-600': rating < {{ $i }} }"
                                    class="w-8 h-8 transition duration-200 ease-in-out"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.4 4.298h4.516c.967 0 1.37 1.24.588 1.81l-3.658 2.641 1.4 4.297c.3.92-.755 1.688-1.54 1.1L10 14.347l-3.657 2.641c-.784.588-1.84-.18-1.54-1.1l1.4-4.297-3.658-2.641c-.782-.57-.38-1.81.588-1.81h4.516l1.4-4.298z" />
                                </svg>
                            @endfor
                            <input type="hidden" x-ref="ratingInput" name="rating" required>
                        </div>
                    </div>

                    <!-- Input Komentar -->
                    <div class="mb-2">
                        <label class="text-gray-400 block mb-1">Komentar</label>
                        <textarea name="comment" class="w-full p-3 rounded-md bg-gray-800 text-white border border-gray-700 focus:ring focus:ring-blue-500 transition" required></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openCommentModal = false" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-md transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md transition">Kirim</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
        <div class="mt-5">
            @foreach ($film->comments as $comment)
                <div class="mb-8" x-data="{ editing: false, openMenu: false }">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                <img src="{{ isset($comment->user->avatar) ? asset('storage/' . $comment->user->avatar) : asset('storage/avatars/default-avatar.png') }}"
                                alt="User Avatar"
                                class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3">
                                <div class="flex items-center gap-2">
                                    <p class="text-white font-semibold">{{ $comment->user->name }}</p>
                                    @if($comment->user->role === 'admin')
                                        <span class="px-2 py-1 text-xs bg-red-500 bg-opacity-30 text-red-700 rounded-lg">Admin</span>
                                    @elseif($comment->user->role === 'author')
                                        <span class="px-2 py-1 text-xs bg-blue-500 bg-opacity-30 text-blue-700 rounded-lg">Author</span>
                                    @endif
                                </div>
                                <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        @if(auth()->id() === $comment->user_id)
                        <div class="relative">
                            <button @click="openMenu = !openMenu" class="text-gray-300 hover:text-white">
                                &#x22EE;
                            </button>
                            <div x-show="openMenu" @click.away="openMenu = false" class="absolute right-0 mt-2 w-40 bg-gray-800 border border-gray-700 rounded-md shadow-lg p-2 z-10">
                                <button @click="editing = true; openMenu = false" class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700 rounded-md">Edit</button>
                                <form action="{{ route('delete-comment', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-700 rounded-md" onclick="return confirm('Hapus komentar ini?')">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div x-show="!editing">
                        @if($comment->user->role !== 'admin' && $comment->user->role !== 'author')
                            <div class="flex items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="fa fa-star {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-400' }}"></span>
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
                                            :class="{ 'text-yellow-500': rating >= {{ $i }}, 'text-gray-600': rating < {{ $i }} }"
                                            class="w-8 h-8 transition duration-200 ease-in-out"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.4 4.298h4.516c.967 0 1.37 1.24.588 1.81l-3.658 2.641 1.4 4.297c.3.92-.755 1.688-1.54 1.1L10 14.347l-3.657 2.641c-.784.588-1.84-.18-1.54-1.1l1.4-4.297-3.658-2.641c-.782-.57-.38-1.81.588-1.81h4.516l1.4-4.298z" />
                                        </svg>
                                    @endfor
                                    <input type="hidden" x-ref="editRatingInput" name="rating" value="{{ $comment->rating }}">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="text-gray-400 block mb-1">Komentar</label>
                                <textarea name="comment" class="w-full p-3 rounded-md bg-gray-800 text-white border border-gray-700 focus:ring focus:ring-blue-500 transition" required>{{ $comment->comment }}</textarea>
                            </div>

                            <div class="flex justify-end gap-3">
                                <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-600 text-white rounded-md">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Comment Section End -->


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

    .bg > * {
        position: relative;
        z-index: 1;
    }
</style>
@endsection
