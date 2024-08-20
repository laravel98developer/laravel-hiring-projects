<!DOCTYPE html>
<html>

<head>
    <title>News</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <h1>News</h1>
    <a href="/">Home</a>
    <div class="border-b p-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $news['title'] }}</h2>
        <p class="text-gray-600 mt-2">{{ $news['content'] }}</p>

        <div class="text-sm text-gray-500 mt-4">
            <small>Source: {{ $news['source'] }}</small><br>
            <span>Author: {{ $news['author'] }}</span>
        </div>

        <a href="{{ $news['url'] }}" target="_blank" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
            Website
        </a>
    </div>

</body>

</html>
