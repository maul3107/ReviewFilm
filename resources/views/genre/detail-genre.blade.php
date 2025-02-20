@extends('layouts')

@section('content')
<div class="judul container m-auto mt-20 flex justify-start items-center gap-5">
    <div x-data>
        <button
            class="rollback text-white p-2 rounded-full w-10 h-10 z-10 text-lg"
            @click="window.history.back()"
        >
            &#10094;
        </button>
    </div>
    <h1 class="judul-hero text-white text-xl sm:text-2xl md:text-left">
        {{ $genre->title }}
    </h1>
</div>

<div class="container m-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5 mt-10">
    @if ($films->isEmpty())
        <p class="text-white text-center col-span-full h-pencarian">Tidak ada film yang tersedia.</p>
    @else
        @foreach ($films as $film)
            <div class="relative">
                <a href="{{ route('detail-film', ['id' => $film->id]) }}" class="block">
                    <div class="h-80">
                        <img src="{{ asset('storage/assets/' . $film->poster) }}" class="rounded-lg shadow-lg w-full h-full object-cover" alt="{{ $film->title }}">
                    </div>
                    <div class="mt-3">
                        <h1 class="text-white text-md">{{ $film->title }}</h1>
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>
</div>

@endsection
