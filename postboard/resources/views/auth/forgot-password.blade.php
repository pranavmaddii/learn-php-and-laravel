@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12">
    <h1 class="text-2xl font-bold mb-6 dark:text-white">Forgot Password</h1>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block mb-1 dark:text-gray-300">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded"
                required
            >

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            Send Reset Link
        </button>
    </form>
</div>
@endsection
