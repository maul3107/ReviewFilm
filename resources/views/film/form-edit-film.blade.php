@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.film.index') }}"class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('admin.update-film', $film->id) }}" method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit Film</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="title">
                    Title
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="title" type="text" name="title" placeholder="Enter movie title" value="{{ old('title', $film->title ?? '') }}">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="poster">
                    Poster
                </label>
                <input class="appearance-none block w-full bg-gray-100 border {{ $errors->has('poster') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="poster" type="file" name="poster">
                @error('poster')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                @if($film->poster)
                    <div class="mt-3">
                        <p class="text-sm text-gray-700">Poster Saat Ini:</p>
                        <img src="{{ asset('storage/assets/' . $film->poster) }}" alt="Poster" class="w-32 h-auto rounded-lg shadow">
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="description" name="description" placeholder="Enter movie description">{{ old('description', $film->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="release_year">
                    Release Year
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('release_year') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="release_year" type="number" name="release_year" placeholder="2024" value="{{ old('release_year', $film->release_year ?? '') }}">
                @error('release_year')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="duration">
                    Duration (minutes)
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('duration') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="duration" type="number" name="duration" placeholder="120" value="{{ old('duration', $film->duration ?? '') }}">
                @error('duration')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="creator">
                    Creator
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('creator') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="creator" type="text" name="creator" placeholder="Director name" value="{{ old('creator', $film->creator ?? '') }}">
                @error('creator')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="trailer">
                    Trailer URL
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('trailer') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="trailer" type="text" name="trailer" placeholder="Enter trailer URL" value="{{ old('trailer', $film->trailer ?? '') }}">
                @error('trailer')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update
            </button>
        </div>
    </form>

@endsection

