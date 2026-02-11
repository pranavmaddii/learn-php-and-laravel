@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <h1 class="text-2xl font-bold mb-6 dark:text-white">Login</h1>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block mb-1 dark:text-gray-300">Email</label>
            <input
                id="email"
                type="text"
                name="login"
                value="{{ old('email') }}"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
                autofocus
            >

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-2">
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

        {{-- Forgot Password --}}
        <div class="mb-6">
            <a href="{{ route('password.request') }}"
               class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                Forgot password?
            </a>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                Login
            </button>

            <a href="{{ route('register') }}"
               class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                New user? Register here
            </a>
        </div>
    </form>
</div>
@endsection
