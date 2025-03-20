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
                    class="appearance-none block w-full bg-whitw text-gray-700 border
                {{ $errors->has('title') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                    {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                    focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white border
                {{ $errors->has('poster') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                {{ $errors->has('description') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                {{ $errors->has('release_year') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                {{ $errors->has('duration') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                {{ $errors->has('creator') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-blue-500"
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
                    class="appearance-none block w-full bg-white text-gray-700 border
                {{ $errors->has('trailer') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500"
                    id="trailer" type="text" name="trailer" placeholder="Enter trailer URL"
                    value="{{ old('trailer') }}">
                @error('trailer')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="age">
                    Age Restriction
                </label>
                <select
                    class="appearance-none block w-full bg-white text-gray-700 border
                    {{ $errors->has('age') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight
                    focus:outline-none focus:bg-white focus:border-blue-500"
                    id="age" name="age">
                    <option value="13" {{ old('age') == '13' ? 'selected' : '' }}>13+</option>
                    <option value="17" {{ old('age') == '17' ? 'selected' : '' }}>17+</option>
                    <option value="21" {{ old('age') == '21' ? 'selected' : '' }}>21+</option>
                </select>
                @error('age')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                for="genre">Genres</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach ($genres as $genre)
                    <label
                        class="flex items-center space-x-2 bg-blue-100 p-2 rounded-lg border border-blue-200 shadow-sm cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                            class="form-checkbox text-blue-500 focus:ring focus:ring-blue-300"
                            {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                        <span class="text-gray-700">{{ $genre->title }}</span>
                    </label>
                @endforeach
            </div>
            @error('genres')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="castings">
                Casting
            </label>
            <div id="castings-container">
                <div class="flex flex-wrap -mx-3 mb-3 casting-item  justify-between">
                    <div class="w-full md:w-1/4 px-3 mb-3 md:mb-0">
                        <input
                            class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="text" name="stage_name[]" placeholder="Stage names" required>
                    </div>
                    <div class="w-full md:w-1/4 px-3 mb-3 md:mb-0">
                        <input
                            class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="text" name="real_name[]" placeholder="Real name" required>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-3 md:mb-0">
                        <input
                            class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-0 px-0 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                            type="file" name="photo[]" accept="image/*">
                    </div>
                    <div class="w-full md:w-1/12 px-3 flex items-center justify-center">
                        <button type="button"
                            class="remove-casting bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline">
                            <span>-</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="button" id="add-casting"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    + Tambah Casting
                </button>
            </div>
            @error('stage_name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            @error('real_name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            @error('photo')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Submit
            </button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('castings-container');
            const addButton = document.getElementById('add-casting');
            const templateItem = document.querySelector('.casting-item'); // Simpan template asli

            // Tambah casting
            addButton.addEventListener('click', function() {
                // Jika container kosong, hapus placeholder dulu
                if (container.children.length === 1 && container.children[0].tagName === 'P') {
                    container.innerHTML = '';
                }

                let newItem;
                if (templateItem) {
                    newItem = templateItem.cloneNode(true);
                } else {
                    console.error("Template tidak ditemukan!");
                    return;
                }

                // Reset input values
                newItem.querySelectorAll('input[type="text"]').forEach(input => {
                    input.value = '';
                });

                // Reset file input
                newItem.querySelectorAll('input[type="file"]').forEach(input => {
                    input.value = '';
                });

                // Tambahkan event hapus pada item baru
                newItem.querySelector('.remove-casting').addEventListener('click', function() {
                    this.closest('.casting-item').remove();
                    checkEmptyContainer();
                });

                container.appendChild(newItem);
            });

            // Hapus casting
            document.querySelectorAll('.remove-casting').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.casting-item').remove();
                    checkEmptyContainer();
                });
            });

            // Fungsi untuk mengecek apakah container kosong
        });
    </script>
@endsection
