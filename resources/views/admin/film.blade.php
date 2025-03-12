@extends('layouts-admin')

@section('content')
    <div class="relative overflow-x-auto sm:rounded-lg">
        <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div>
                <a href="{{ route('admin.create-film') }}"
                    class="inline-flex items-center text-white font-medium rounded-lg text-sm px-3 py-2 bg-blue-600">
                    Tambah Data
                </a>
            </div>
            <div class="relative">
                <form method="GET" action="{{ route('admin.film.index') }}">
                    @csrf
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Berdasarkan Title"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                </form>
            </div>
        </div>

        <table class="w-full text-sm text-left text-black border border-gray-300">
            <thead class="text-md font-bold text-gray-700 uppercase bg-gray-50 border border-gray-300">
                <tr>
                    <th class="border border-gray-300 px-6 py-3">Id</th>
                    <th class="border border-gray-300 px-6 py-3">Title</th>
                    <th class="border border-gray-300 px-6 py-3">Poster</th>
                    <th class="border border-gray-300 px-6 py-3">Creator</th>
                    <th class="border border-gray-300 px-6 py-3">Trailer</th>
                    <th class="border border-gray-300 px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($films as $film)
                    <tr class="bg-white border border-gray-300">
                        <td class="border border-gray-300 px-6 py-4">{{ $film->id }}</td>
                        <td class="border border-gray-300 px-6 py-4">{{ $film->title }}</td>
                        <td class="border border-gray-300 px-6 py-4">
                            <img src="{{ asset('storage/assets/' . $film->poster) }}" alt="Poster"
                                class="w-20 h-28 object-cover rounded-lg">
                        </td>
                        <td class="border border-gray-300 px-6 py-4">{{ $film->creator }}</td>
                        <td class="border border-gray-300 px-6 py-4">
                            <a href="{{ $film->trailer }}" target="_blank" class="text-blue-600 hover:underline">Watch</a>
                        </td>
                        <td class="px-6 py-8 flex justify-center items-center space-x-3">
                            <a href="{{ route('admin.edit-film', $film->id) }}" class="text-yellow-500 hover:underline">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.delete-film', $film->id) }}" method="POST"
                                class="inline delete-form" data-title="{{ $film->title }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="py-4">
            {{ $films->appends(request()->query())->links() }}
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: true
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const filmTitle = form.getAttribute('data-title');

                    Swal.fire({
                        title: "Yakin ingin hapus?",
                        text: `Film "${filmTitle}" akan dihapus permanen`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
