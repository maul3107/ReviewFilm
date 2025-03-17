@extends(auth()->user()->role == 'author' ? 'layouts-author' : 'layouts-admin')

@section('content')
    <div>
        <a href="{{ route(auth()->user()->role == 'author' ? 'author.genre-relation.index' : 'admin.genre-relation.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-5">
            {{ session('success') }}
        </div>
    @endif

    <form
        action="{{ route(auth()->user()->role == 'author' ? 'author.store-genre-relation' : 'admin.store-genre-relation') }}"
        method="POST" class="form-input-data w-fullcontainer m-auto mt-5 p-10 rounded-lg">
        @csrf
        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Tambah Genre Relation</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="film_id">
                    Film
                </label>
                <select name="film_id" id="film_id"
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('film_id') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="">Pilih Film</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" {{ old('film_id') == $film->id ? 'selected' : '' }}>
                            {{ $film->title }}
                        </option>
                    @endforeach
                </select>
                @error('film_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="genres">
                    Genres
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach ($genres as $genre)
                        <label
                            class="flex items-center bg-gray-100 p-2 rounded-lg shadow-sm hover:bg-gray-200 cursor-pointer"
                            for="genre-{{ $genre->id }}">
                            <input type="checkbox" name="genre_id[]" id="genre-{{ $genre->id }}"
                                value="{{ $genre->id }}" class="hidden peer"
                                {{ in_array($genre->id, old('genre_id', [])) ? 'checked' : '' }}>
                            <div
                                class="w-5 h-5 border-2 border-gray-400 rounded peer-checked:bg-blue-500 peer-checked:border-blue-500 mr-2 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white hidden peer-checked:block" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            {{ $genre->title }}
                        </label>
                    @endforeach
                </div>
                @error('genres')
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
