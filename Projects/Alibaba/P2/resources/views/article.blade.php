@extends('layout')

@section('title')
<title>Page Title</title>
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4 py-10">
    <div class="col-span-3">
        <embed src="{{ Storage::url($article->file) }}" width="600" height="500" alt="pdf" />
        <h1 class="mt-5 mb-2 text-center text-2xl font-bold">{{ $article->title }}</h1>
        <p class="mb-5 text-center text-sm text-slate-500 italic">By {{ $article->user->name }} | {{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}</p>

        <div>{!! $article->content !!}</div>

        <div class="my-5">
            @foreach ($article->tags as $tag)
            <a href="{{ route('tag', ['tag' => $tag->id]) }}" class="text-blue-500 hover:underline" mr-3">#{{ $tag->name }}</a>
            @endforeach
        </div>

        <hr>

        <!-- Related articles -->

        <div class="grid grid-cols-3 gap-4 my-5">
            @if(!empty($related_articles))
            @foreach ($related_articles as $article)
            <!-- post -->
            <div class="mb-4 ring-1 ring-slate-200 rounded-md h-fit hover:shadow-md">
                <a href="{{ route('show', ['articleId' => $article->id]) }}"><img class="rounded-t-md object-cover h-60 w-full" src="{{ Storage::url($article->cover) }}" alt="..." /></a>
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
            @endif
        </div>

    </div>
    @include('vendor.sidebar')
</div>
@endsection
