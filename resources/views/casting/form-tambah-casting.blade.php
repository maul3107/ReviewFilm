@extends(auth()->user()->role == 'author' ? 'layouts-author' : 'layouts-admin')

@section('content')
    <div>
        <a href="{{ route(auth()->user()->role == 'author' ? 'author.casting.index' : 'admin.casting.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route(auth()->user()->role == 'author' ? 'author.store-casting' : 'admin.store-casting') }}"
        method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Tambah Casting</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="photo">
                    Foto
                </label>
                <input type="file" name="photo" id="photo"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('photo') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                @error('photo')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="stage_name">
                    Nama Panggung
                </label>
                <input type="text" name="stage_name" id="stage_name" value="{{ old('stage_name') }}"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('stage_name') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Nama panggung">
                @error('stage_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="real_name">
                    Nama Asli
                </label>
                <input type="text" name="real_name" id="real_name" value="{{ old('real_name') }}"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('real_name') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Nama asli">
                @error('real_name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="film_id">
                    Nama Film
                </label>
                <select name="film_id" id="film_id"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('film_id') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    <option value="">Pilih Film</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" {{ old('film_id') == $film->id ? 'selected' : '' }}>
                            {{ $film->title }}</option>
                    @endforeach
                </select>
                @error('film_id')
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
