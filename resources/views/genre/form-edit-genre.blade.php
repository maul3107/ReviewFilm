@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.genre.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('admin.update-genre', $genre->id) }}" method="POST"
        class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit Genre</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="title">
                    Title
                </label>
                <input
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="title" type="text" name="title" placeholder="Enter genre title"
                    value="{{ old('title', $genre->title ?? '') }}">
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
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    id="slug" type="text" name="slug" placeholder="Enter genre slug"
                    value="{{ old('slug', $genre->slug ?? '') }}">
                @error('slug')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                Update
            </button>
        </div>
    </form>
@endsection
