@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

    <h2 class="text-2xl font-bold mb-6 dark:text-white">
        Create a New Post
    </h2>

    <form method="POST" action="{{ route('posts.store') }}" class="max-w-xl" enctype="multipart/form-data">

        @csrf

        <!-- Title -->
        <div class="mb-5">
            <label class="block font-medium mb-1 dark:text-gray-300">
                Title
            </label>

            <input type="text" name="title"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                value="{{ old('title') }}" placeholder="Enter post title">
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

            <textarea name="body" rows="4"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                placeholder="Write your post...">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-6">
            <label class="block font-medium mb-1 dark:text-gray-300">
                Image (optional)
            </label>

            <div class="flex items-center gap-3">
                <label class="cursor-pointer inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm py-2 px-4 rounded border border-gray-300 dark:border-gray-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Choose file
                    <input type="file" name="image" accept="image/*" id="image-input" class="hidden">
                </label>
                <span id="file-name" class="text-sm text-gray-500 dark:text-gray-400"></span>
            </div>
            @error('image')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Create Post
            </button>

            <a href="{{ route('posts.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                Cancel
            </a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image-input');
        const fileNameSpan = document.getElementById('file-name');

        if (imageInput && fileNameSpan) {
            imageInput.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '';
                fileNameSpan.textContent = fileName;
            });
        }
    });
</script>
@endsection
