@extends(auth()->user()->role == 'author' ? 'layouts-author' : 'layouts-admin')

@section('content')
    <div>
        <a href="{{ route(auth()->user()->role == 'author' ? 'author.film.index' : 'admin.film.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>

    <form action="{{ route(auth()->user()->role == 'author' ? 'author.store-film' : 'admin.store-film') }}" method="POST"
        class="form-input-data w-fullcontainer m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Tambah Film</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('title') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="title" type="text" name="title" placeholder="Enter movie title"
                    value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="slug">
                    Slug
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                    {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                    focus:outline-none focus:bg-white focus:border-gray-500"
                    id="slug" type="text" name="slug" placeholder="Enter movie slug" value="{{ old('slug') }}">
                @error('slug')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="poster">
                    Poster URL
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 border
                {{ $errors->has('poster') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="poster" type="file" name="poster" value="{{ old('poster') }}">
                @error('poster')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="description">
                    Description
                </label>
                <textarea
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('description') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="description" name="description" placeholder="Enter movie description">{{ old('description') }}</textarea>
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
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('release_year') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="release_year" type="number" name="release_year" placeholder="2024"
                    value="{{ old('release_year') }}">
                @error('release_year')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="duration">
                    Duration (minutes)
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('duration') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="duration" type="number" name="duration" placeholder="120" value="{{ old('duration') }}">
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
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('creator') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="creator" type="text" name="creator" placeholder="Director name" value="{{ old('creator') }}">
                @error('creator')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="trailer">
                    Trailer URL
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border
                {{ $errors->has('trailer') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="trailer" type="text" name="trailer" placeholder="Enter trailer URL"
                    value="{{ old('trailer') }}">
                @error('trailer')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Submit
            </button>
        </div>
    </form>
@endsection
