@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <h1 class="text-2xl font-bold mb-6 dark:text-white">Register</h1>

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block mb-1 dark:text-gray-300">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Username --}}
        <div class="mb-4">
            <label for="username" class="block mb-1 dark:text-gray-300">Username</label>
            <input
                id="username"
                type="text"
                name="username"
                value="{{ old('username') }}"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >

            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone Number --}}
        <div class="mb-4">
            <label for="phone_number" class="block mb-1 dark:text-gray-300">Phone Number</label>
            <input
                id="phone_number"
                type="text"
                name="phone_number"
                value="{{ old('phone_number') }}"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >

            @error('phone_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block mb-1 dark:text-gray-300">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 dark:text-gray-300">
                Confirm Password
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >
        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Register
            </button>

            <a
                href="{{ route('login') }}"
                class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
            >
                Already have an account? Login
            </a>
        </div>
    </form>
</div>
@endsection
