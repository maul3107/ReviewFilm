@extends('layouts')

@section('content')
    <x-app-layout>
        <div class="bg-black">
            <div class="container mx-auto">
                <div class="p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="form-section p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="form-section p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    <style>
        .form-section {
            margin: 20px 0;
        }
    </style>
@endsection
