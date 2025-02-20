@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.comment.index') }}" class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('admin.store-comment') }}" method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg">
        @csrf
        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Tambah Komentar</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="comment">
                    Komentar
                </label>
                <textarea class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('comment') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="comment" name="comment" placeholder="Masukkan komentar">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="film_id">
                    Film
                </label>
                <select name="film_id" id="film_id" class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('film_id') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="" disabled selected>Pilih Film</option>
                    @foreach($films as $film)
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

        <div class="flex justify-end">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>
        </div>
    </form>
@endsection
