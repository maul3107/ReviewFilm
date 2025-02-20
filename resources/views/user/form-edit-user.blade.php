@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.user.index') }}" class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('admin.update-user', $user->id) }}" method="POST" class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h1 class="text-3xl text-gray-800 font-bold mb-5">Form Edit User</h1>

        <!-- Username -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="name">
                    Username
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" type="text" name="name" placeholder="Enter username" value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="email">
                    Email
                </label>
                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email" name="email" placeholder="Enter email" value="{{ old('email', $user->email) }}">
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Role -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="role">
                    Role
                </label>
                <select name="role" id="role" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ old('role', $user->role) == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Profile Picture -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="avatar">
                    Profile Picture
                </label>

                @if ($user->avatar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif

                <input class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       id="avatar" type="file" name="avatar">
                @error('avatar')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
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
