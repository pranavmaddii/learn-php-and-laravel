@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <h1 class="text-2xl font-bold mb-6 dark:text-white">Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label for="email" class="block mb-1 dark:text-gray-300">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 dark:text-gray-300">New Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >
        </div>

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

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            Reset Password
        </button>
    </form>
</div>
@endsection
