<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('categories.create') }}">
                <x-primary-button>{{ __('New') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="POST" class="mt-6 space-y-3">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <x-input-label for="title">{{ __('Category Name') }}</x-input-label>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $category->name }}" required autofocus autocomplete="name" />
                        <br>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>