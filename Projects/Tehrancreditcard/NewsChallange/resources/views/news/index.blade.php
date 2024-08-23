<!DOCTYPE html>
<html>

<head>
    <title>News</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <h1 class="flex items-center justify-center font-extrabold text-2xl">Latest News</h1>

    <!-- Filter Form -->
    <form method="GET" class="flex justify-center mb-6 space-x-4">
        <select name="source" class="border p-2 rounded">
            <option value="">All Sources</option>
            @foreach ($sources as $source)
                <option value="{{ $source }}" {{ $source == $selectedSource ? 'selected' : '' }}>
                    {{ $source }}
                </option>
            @endforeach
        </select>

        <input type="date" name="published_at" class="border p-2 rounded" value="{{ $selectedDate }}">
        
        <button type="submit" class="ml-2 p-2 bg-blue-600 text-white rounded hover:bg-blue-800">Filter</button>
    </form>

    <ul class="space-y-6">
        @foreach ($news as $article)
            <li class="border-b p-6">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $article['title'] }}</h2>

                <div class="text-sm text-gray-500 mt-4">
                    <small>Source: {{ $article['source'] }}</small><br>
                    <span>Author: {{ $article['author'] }}</span><br>
                    <span>Published At: {{ $article['published_at'] }}</span>
                </div>

                <a href="/{{ $article['external_id'] }}" target="_blank"
                    class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                    Read more
                </a>
            </li>
        @endforeach
    </ul>
</body>



</html>
