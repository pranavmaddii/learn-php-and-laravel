@extends('layouts.app')

@section('title', 'My Posts')

@section('content')

    <h1 class="text-2xl font-bold mb-6 dark:text-white">
        My Posts
    </h1>

    @if ($posts->isEmpty())
        <div class="text-center text-gray-500 dark:text-gray-400 py-12">
            <p class="text-lg mb-2">You haven't created any posts yet</p>
            <a href="{{ route('posts.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                Create your first post
            </a>
        </div>
    @else
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-4 mb-4">
                <a href="{{ route('posts.show', $post->id) }}" class="text-xl font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $post->title }}
                </a>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ Str::limit($post->body, 100) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        @endforeach

        {{ $posts->links() }}
    @endif

@endsection
