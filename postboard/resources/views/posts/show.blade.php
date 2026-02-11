@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="max-w-2xl">

        {{-- Post Title --}}
        <h1 class="text-2xl font-bold mb-2 dark:text-white">
            {{ $post->title }}
        </h1>

        {{-- Author and time --}}
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            Posted by <span class="font-medium">{{ $post->user->username }}</span>
            · {{ $post->created_at->diffForHumans() }}
        </p>

        {{-- Post Body --}}
        <p class="text-gray-700 dark:text-gray-300 mb-4">
            {{ $post->body }}
        </p>

        {{-- Post Image --}}
        @if ($post->image)
            <div class="my-4">
                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="max-w-full rounded-lg shadow-md"
                >
            </div>
        @endif

        {{-- Like Button --}}
        <div class="mb-8">
            <button
                id="like-btn"
                data-post-id="{{ $post->id }}"
                data-liked="{{ $post->likes->contains(Auth::id()) ? 'true' : 'false' }}"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border transition
                    {{ $post->likes->contains(Auth::id())
                        ? 'bg-red-100 border-red-300 text-red-600 dark:bg-red-900 dark:border-red-700 dark:text-red-400'
                        : 'bg-gray-100 border-gray-300 text-gray-600 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400'
                    }}
                    hover:scale-105"
            >
                {{-- Heart Icon --}}
                <span id="heart-icon">
                    @if ($post->likes->contains(Auth::id()))
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    @else
                        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    @endif
                </span>
                <span id="like-count">{{ $post->likes->count() }}</span>
                <span id="like-text">{{ $post->likes->count() == 1 ? 'Like' : 'Likes' }}</span>
            </button>
        </div>

        {{-- Actions (only show if this is YOUR post) --}}
        @if (Auth::user()->id == $post->user_id)
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('posts.edit', $post->id) }}"
                    class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Edit
                </a>

                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        @endif

        <hr class="my-8 dark:border-gray-700">

        {{-- Comment Form --}}
        <h2 class="text-xl font-bold mb-4 dark:text-white">Leave a Comment</h2>

        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
            @csrf

            <textarea
                name="body"
                rows="3"
                class="w-full border dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg p-3 mb-2"
                placeholder="Write your comment..."
                required
            ></textarea>

            @error('body')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Post Comment
            </button>
        </form>

        {{-- Comments List --}}
        <h2 class="text-xl font-bold mb-4 dark:text-white">
            Comments ({{ $comments->total() }})
        </h2>

        @if ($comments->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
        @else
            @foreach ($comments as $comment)
                <div class="bg-gray-50 dark:bg-gray-800 border dark:border-gray-700 rounded-lg p-4 mb-4">
                    {{-- Comment body --}}
                    <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $comment->body }}</p>

                    {{-- Commenter username and time --}}
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-medium">{{ $comment->user->username }}</span>
                        · {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
            {{ $comments->links() }}
        @endif

        <a href="{{ route('posts.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mt-4 inline-block">
            ← Back to All Posts
        </a>

    </div>

@endsection

@section('scripts')
<script>
    document.getElementById('like-btn').addEventListener('click', function() {
        const btn = this;
        const postId = btn.dataset.postId;
        const isLiked = btn.dataset.liked === 'true';

        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update the button state
            btn.dataset.liked = data.liked ? 'true' : 'false';

            // Update count
            document.getElementById('like-count').textContent = data.count;
            document.getElementById('like-text').textContent = data.count == 1 ? 'Like' : 'Likes';

            // Update heart icon
            const heartIcon = document.getElementById('heart-icon');
            if (data.liked) {
                heartIcon.innerHTML = '<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                btn.classList.remove('bg-gray-100', 'border-gray-300', 'text-gray-600', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-gray-400');
                btn.classList.add('bg-red-100', 'border-red-300', 'text-red-600', 'dark:bg-red-900', 'dark:border-red-700', 'dark:text-red-400');
            } else {
                heartIcon.innerHTML = '<svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                btn.classList.remove('bg-red-100', 'border-red-300', 'text-red-600', 'dark:bg-red-900', 'dark:border-red-700', 'dark:text-red-400');
                btn.classList.add('bg-gray-100', 'border-gray-300', 'text-gray-600', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-gray-400');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
