<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tag: {{ $tag->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($articles as $article)
            @if($article)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 px-4 h-20 flex justify-between items-center">
                <div class="text-gray-900 dark:text-gray-100">
                    <a href="{{ route('articles.show', ['post' => $article->id]) }}" class="hover:underline">{{ $article->name }}</a>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('articles.edit', ['post' => $article->id]) }}"> <x-primary-button>{{ __('Edit') }}</x-primary-button></a>
                    <a href="{{ route('articles.destroy', ['post' => $article->id]) }}"> <x-danger-button>{{ __('Delete') }}</x-danger-button></a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
