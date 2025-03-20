@extends('layouts-admin')

@section('content')
    <div>
        <a href="{{ route('admin.user.index') }}"
            class="rollback text-white py-2 px-4 rounded-full w-10 h-10 z-10 text-lg">&#10094;</a>
    </div>
    <form action="{{ route('admin.store-user') }}" method="POST"
        class="form-input-data w-full container m-auto mt-5 p-10 rounded-lg">
        @csrf
        <h1 class="text-3xl text-gray-900 font-bold mb-5">Form Tambah User</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="name">
                    Nama
                </label>
                <input type="text" id="name" name="name"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Masukkan Nama" value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="email">
                    Email
                </label>
                <input type="email" id="email" name="email"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Masukkan Email" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="password">
                    Password
                </label>
                <input type="password" id="password" name="password"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Masukkan Password">
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="nomor_telepon">
                    Nomor Telepon
                </label>
                <input type="text" id="nomor_telepon" name="nomor_telepon"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('nomor_telepon') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Masukkan No Telp" value="{{ old('nomor_telepon') }}">
                @error('nomor_telepon')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-900 text-xs font-bold mb-2" for="role">
                    Role
                </label>
                <select name="role" id="role"
                    class="appearance-none block w-full bg-white text-gray-700 border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
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
