<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('articles.create') }}">
                <x-primary-button>{{ __('New Post') }}</x-primary-button>
            </a>
        </div>
    </br>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($articles as $article)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 px-4 h-20 flex justify-between items-center">
                <div class="text-gray-900 dark:text-gray-100">
                    <p>{{ $article->title }}</p>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('articles.edit', ['article' => $article->id]) }}"> <x-primary-button>{{ __('Edit') }}</x-primary-button></a>
                    <form method="post" action="{{ route('articles.destroy', ['article' => $article->id]) }}" class="inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <x-danger-button>
                            {{ __('Delete') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
