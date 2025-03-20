@extends(auth()->user()->role == 'author' ? 'layouts-author' : 'layouts-admin')

@section('content')
    <div>
        <a
            href="{{ route(auth()->user()->role == 'author' ? 'author.film.index' : 'admin.film.index') }}"class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route(auth()->user()->role == 'author' ? 'author.update-film' : 'admin.update-film', $film->id) }}"
        method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit Film</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="title" type="text" name="title" placeholder="Enter movie title"
                    value="{{ old('title', $film->title ?? '') }}">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="slug">
                    Slug
                </label>
                <input
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="slug" type="text" name="slug" placeholder="Enter movie slug"
                    value="{{ old('slug', $film->slug ?? '') }}">
                @error('slug')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="poster">
                    Poster
                </label>
                <input
                    class="appearance-none block w-full bg-white border {{ $errors->has('poster') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="poster" type="file" name="poster">
                @error('poster')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                @if ($film->poster)
                    <div class="mt-3">
                        <p class="text-sm text-gray-700">Poster Saat Ini:</p>
                        <img src="{{ asset('storage/assets/' . $film->poster) }}" alt="Poster"
                            class="w-32 h-auto rounded-lg shadow">
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="description">
                    Description
                </label>
                <textarea
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="description" name="description" placeholder="Enter movie description">{{ old('description', $film->description ?? '') }}</textarea>
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
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('release_year') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="release_year" type="number" name="release_year" placeholder="2024"
                    value="{{ old('release_year', $film->release_year ?? '') }}">
                @error('release_year')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="duration">
                    Duration (minutes)
                </label>
                <input
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('duration') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="duration" type="number" name="duration" placeholder="120"
                    value="{{ old('duration', $film->duration ?? '') }}">
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
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('creator') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="creator" type="text" name="creator" placeholder="Director name"
                    value="{{ old('creator', $film->creator ?? '') }}">
                @error('creator')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="trailer">
                    Trailer URL
                </label>
                <input
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('trailer') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="trailer" type="text" name="trailer" placeholder="Enter trailer URL"
                    value="{{ old('trailer', $film->trailer ?? '') }}">
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
                    <option value="13" {{ old('age', $film->age ?? '') == '13' ? 'selected' : '' }}>13+</option>
                    <option value="17" {{ old('age', $film->age ?? '') == '17' ? 'selected' : '' }}>17+</option>
                    <option value="21" {{ old('age', $film->age ?? '') == '21' ? 'selected' : '' }}>21+</option>
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
                            {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }}>
                        <span class="text-gray-700">{{ $genre->title }}</span>
                    </label>
                @endforeach
            </div>
            @error('genres')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Add this section after the genres section -->
        <div class="mb-6">
            <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="castings">
                Casting
            </label>
            <div id="castings-container">
                @if ($film->castings->count() > 0)
                    @foreach ($film->castings as $index => $casting)
                        <div class="flex flex-wrap items-center -mx-3 mb-3 casting-item">
                            <input type="hidden" name="casting_id[]" value="{{ $casting->id }}">

                            <div class="w-full md:w-1/5 px-3">
                                <input
                                    class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                    type="text" name="stage_name[]" placeholder="Nama karakter"
                                    value="{{ $casting->stage_name }}" required>
                            </div>

                            <div class="w-full md:w-1/5 px-3">
                                <input
                                    class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                    type="text" name="real_name[]" placeholder="Nama asli aktor"
                                    value="{{ $casting->real_name }}" required>
                            </div>

                            <div class="w-full md:w-2/5 px-3 flex items-center">
                                <input
                                    class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-0 px-0 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                    type="file" name="photo[]" accept="image/*">

                                @if ($casting->photo)
                                    <div class="ml-3">
                                        <img src="{{ asset('storage/assets/' . $casting->photo) }}" alt="Actor Photo"
                                            class="w-16 h-auto rounded">
                                        <input type="hidden" name="existing_photo[]" value="{{ $casting->photo }}">
                                    </div>
                                @endif
                            </div>

                            <div class="w-full md:w-1/5 px-3 flex items-center justify-center">
                                <button type="button"
                                    class="remove-casting bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline">
                                    <span>-</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-wrap items-center -mx-3 mb-3 casting-item">
                        <div class="w-full md:w-1/5 px-3">
                            <input
                                class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                type="text" name="stage_name[]" placeholder="Stage name" required>
                        </div>

                        <div class="w-full md:w-1/5 px-3">
                            <input
                                class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                type="text" name="real_name[]" placeholder="Real name" required>
                        </div>

                        <div class="w-full md:w-2/5 px-3 flex items-center">
                            <input
                                class="appearance-none block w-full bg-white text-gray-700 border border-gray-400 rounded py-0 px-0 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                type="file" name="photo[]" accept="image/*">
                        </div>

                        <div class="w-full md:w-1/5 px-3 flex items-center justify-center">
                            <button type="button"
                                class="remove-casting bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline">
                                <span>-</span>
                            </button>
                        </div>
                    </div>
                @endif
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
                Update
            </button>
        </div>
    </form>
    <!-- Add this JavaScript to handle the add/remove casting functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('castings-container');
            const addButton = document.getElementById('add-casting');
            const templateItem = document.querySelector('.casting-item'); 

            addButton.addEventListener('click', function() {
                let newItem;
                const castingItems = document.querySelectorAll('.casting-item');

                if (castingItems.length === 0) {
                    // Jika tidak ada casting-item, buat dari template
                    newItem = templateItem.cloneNode(true);
                } else {
                    // Jika ada, clone item terakhir
                    const lastItem = castingItems[castingItems.length - 1];
                    newItem = lastItem.cloneNode(true);
                }

                // Bersihkan input
                newItem.querySelectorAll('input[type="text"], input[type="file"]').forEach(input => {
                    input.value = '';
                });

                // Hapus preview gambar jika ada
                const photoPreview = newItem.querySelector('img');
                if (photoPreview) {
                    photoPreview.parentNode.remove();
                }

                // Hapus ID casting jika ada
                const castingIdInput = newItem.querySelector('input[name="casting_id[]"]');
                if (castingIdInput) {
                    castingIdInput.remove();
                }

                // Tambahkan event hapus
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
        });
    </script>

@endsection
