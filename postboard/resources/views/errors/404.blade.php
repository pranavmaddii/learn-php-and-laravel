@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')

<div class="flex flex-col items-center justify-center min-h-[60vh] text-center">

    {{-- Large 404 --}}
    <h1 class="text-9xl font-bold text-gray-200 dark:text-gray-700">
        404
    </h1>

    {{-- Message --}}
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-4">
        Page Not Found
    </h2>

    <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-md">
        Sorry, the page you're looking for doesn't exist or has been moved.
    </p>

    {{-- Back to Home Button --}}
    <a href="{{ url('/') }}"
       class="mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
        Go Back Home
    </a>

</div>

@endsection
