@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.comment.index') }}" class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('update-comment', $comment->id) }}" method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit Comment</h1>

        <!-- Comment -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="comment">
                    Comment
                </label>
                <textarea class="appearance-none block w-full bg-gray-100 text-gray-700 border {{ $errors->has('comment') ? 'border-red-500' : 'border-gray-400' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="comment" name="comment" placeholder="Enter comment">{{ old('comment', $comment->comment) }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- User -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="user_id">
                    User
                </label>
                <input type="text" name="user_name" id="user_name"
                       class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                       value="{{ $comment->user->name ?? 'Unknown' }}" readonly>
                <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
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
                       value="{{ $comment->film->title ?? 'Unknown' }}" readonly>
                <input type="hidden" name="film_id" value="{{ $comment->film_id }}">
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Update
            </button>
        </div>
    </form>
@endsection
