@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

    <h2 class="text-2xl font-bold mb-6 dark:text-white">
        Edit Post
    </h2>

    <form method="POST" action="{{ route('posts.update', $post->id) }}" class="max-w-xl">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-5">
            <label class="block font-medium mb-1 dark:text-gray-300">
                Title
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $post->title) }}"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
            >

            @error('title')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Body -->
        <div class="mb-6">
            <label class="block font-medium mb-1 dark:text-gray-300">
                Body
            </label>

            <textarea
                name="body"
                rows="5"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
            >{{ old('body', $post->body) }}</textarea>

            @error('body')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
            >
                Update Post
            </button>

            <a href="{{ route('posts.show', $post->id) }}"
               class="text-gray-600 dark:text-gray-400 hover:underline">
                Cancel
            </a>
        </div>

    </form>

@endsection
