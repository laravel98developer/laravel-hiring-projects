<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Category: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 px-4 h-20 flex justify-between items-center">
                <div class="text-gray-900 dark:text-gray-100">
                    <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="hover:underline">{{ $post->name }}</a>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}"> <x-primary-button>{{ __('Edit') }}</x-primary-button></a>
                    <a href="{{ route('posts.destroy', ['post' => $post->id]) }}"> <x-danger-button>{{ __('Delete') }}</x-danger-button></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>