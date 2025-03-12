@extends(auth()->user()->role == 'author' ? 'layouts-author' : 'layouts-admin')

@section('content')
    <div>
        <a href="{{ route(auth()->user()->role == 'author' ? 'author.casting.index' : 'admin.casting.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form
        action="{{ route(auth()->user()->role == 'author' ? 'author.update-casting' : 'admin.update-casting', $film->id) }}"
        method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit Casting</h1>

        <!-- Stage Name -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="stage_name">
                    Stage Name
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('stage_name') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="stage_name" type="text" name="stage_name" placeholder="Enter stage name"
                    value="{{ old('stage_name', $casting->stage_name) }}">
                @error('stage_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Real Name -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="real_name">
                    Real Name
                </label>
                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('real_name') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="real_name" type="text" name="real_name" placeholder="Enter real name"
                    value="{{ old('real_name', $casting->real_name) }}">
                @error('real_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Film -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="film_id">
                    Film
                </label>
                <input type="text" name="film_title" id="film_title"
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                    value="{{ $casting->film->title ?? 'Unknown' }}" readonly>
                <input type="hidden" name="film_id" value="{{ $casting->film_id }}">
                @error('film_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Photo -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="photo">
                    Photo
                </label>

                <!-- Menampilkan foto saat ini jika ada -->
                @if ($casting->photo)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $casting->photo) }}" alt="Casting Photo"
                            class="w-32 h-32 object-cover rounded">
                    </div>
                @endif

                <input
                    class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('photo') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="photo" type="file" name="photo">
                @error('photo')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Update
            </button>
        </div>
    </form>
@endsection
