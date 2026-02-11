@extends('layouts.app')

@section('title', 'Deleted Posts')

@section('content')

    <h1 class="text-2xl font-bold mb-6 dark:text-white">
        Deleted Posts
    </h1>

    @if ($posts->isEmpty())
        <div class="text-center text-gray-500 dark:text-gray-400 py-12">
            <p class="text-lg mb-2">No deleted posts</p>
            <a href="{{ route('posts.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                Back to All Posts
            </a>
        </div>
    @else
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-4 mb-4">
                <h2 class="text-xl font-semibold dark:text-white">
                    {{ $post->title }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    {{ Str::limit($post->body, 100) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Deleted {{ $post->updated_at->diffForHumans() }}
                </p>

                {{-- Restore Button --}}
                <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Restore
                    </button>
                </form>
            </div>
        @endforeach

        {{ $posts->links() }}
    @endif

    <a href="{{ route('posts.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mt-4 inline-block">
        ← Back to All Posts
    </a>

@endsection
