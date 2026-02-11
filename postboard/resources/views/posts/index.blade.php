@extends('layouts.app')

@section('title', 'All Posts')

@section('content')

    <h1 class="text-2xl font-bold mb-6 dark:text-white">
        All Posts
    </h1>
    {{-- Search Form --}}
    <form method="GET" action="{{ route('posts.index') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                class="flex-1 border dark:border-gray-600 dark:bg-gray-800 dark:text-white px-3 py-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Search
            </button>
        </div>
    </form>



    @if ($posts->isEmpty())
        <div class="text-center text-gray-500 dark:text-gray-400 py-12">
            <p class="text-lg mb-2">No posts yet</p>
            <a href="{{ route('posts.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                Create your first post
            </a>
        </div>
    @else
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-sm mb-6 p-5">

                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="text-gray-700 dark:text-gray-300">
                    {{ \Illuminate\Support\Str::limit($post->body, 120) }}
                </p>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Posted by <span class="font-medium">{{ $post->user->username }}</span>
                    · {{ $post->created_at->diffForHumans() }}
                </p>

            </div>
        @endforeach
        {{-- Pagination Links --}}
        {{ $posts->withQueryString()->links() }}
    @endif
@endsection
