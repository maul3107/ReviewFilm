@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.genre-relation.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-5">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.update-genre-relation', $film->id) }}" method="POST"
        class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Edit Genre Relation</h1>

        <!-- Pilihan Film -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label for="film_id" class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2">
                    Film
                </label>
                <input type="hidden" name="film_id" value="{{ $film->id }}">

                <input type="text"
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    value="{{ $film->title }}" readonly>

                @error('film_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Pilihan Genre -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label for="genres" class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2">
                    Genres
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach ($genres as $genre)
                        <label
                            class="flex items-center bg-gray-100 p-2 rounded-lg shadow-sm hover:bg-gray-200 cursor-pointer"
                            for="genre-{{ $genre->id }}">
                            <input type="checkbox" name="genre_id[]" id="genre-{{ $genre->id }}"
                                value="{{ $genre->id }}" class="hidden peer"
                                {{ in_array($genre->id, old('genre_id', $selectedGenres)) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-400 rounded peer-checked:bg-blue-500 peer-checked:border-blue-500 mr-2 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            {{ $genre->title }}
                        </label>
                    @endforeach
                </div>
                @error('genre_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>
    </form>
@endsection
