<!-- List of posts -->
<div class="grid grid-cols-3 gap-4">
    @foreach ($articles as $article)
    <!-- post -->
    <div class="mb-4 ring-1 ring-slate-200 rounded-md h-fit hover:shadow-md">
        <a href="{{ route('show', ['articleId' => $article->id]) }}"><embed class="rounded-t-md object-cover h-60 w-full" src="{{ Storage::url($article->file) }}" alt="..." /></a>
        <div class="m-4 grid gap-2">
            <div class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}
            </div>
            <h2 class="text-lg font-bold">{{ $article->title }}</h2>
            <p class="text-base">
                {{ Str::limit(strip_tags($article->content), 150, '...') }}
            </p>
            <a class="bg-blue-500 hover:bg-blue-700 rounded-md p-2 text-white uppercase text-sm font-semibold font-sans w-fit focus:ring" href="{{ route('show', ['articleId' => $article->id]) }}">Read more →</a>
        </div>
    </div>
    @endforeach
</div>

{{ $articles->links() }}
