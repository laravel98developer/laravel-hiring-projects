<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }}
            </h2>
            <a href="{{ route('articles.create') }}">
                <x-primary-button>{{ __('New') }}</x-primary-button>
            </a>
        </div>

        <script src="https://cdn.tiny.cloud/1/iof9kfr6e415nls3i08zrsyjecrioli6pylqkbr6gglv72op/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('articles.update', ['article' => $article->id]) }}" method="POST" class="mt-6 space-y-3" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="checkbox" name="is_published" id="is_published" @checked($article->is_published)/>
                        <x-input-label for="is_published">Make this article public</x-input-label>
                        <br>
                        <x-input-label for="title">{{ __('Title') }}</x-input-label>
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" value="{{ $article->title }}" />
                        <br>
                        <x-input-label for="content">{{ __('Content') }}</x-input-label>
                        <textarea name="content" id="content" cols="30" rows="30">{{ $article->content }}</textarea>
                        <br>
                        <x-input-label for="cover">{{ __('Update Cover Image') }}</x-input-label>
                        <img src="{{ Illuminate\Support\Facades\Storage::url($article->file) }}" alt="cover image" width="200">
                        <x-text-input id="cover" name="cover" type="file" class="mt-1 block w-full" autofocus autocomplete="cover" />
                        <br>
                        <x-input-label for="category">{{ __('Category') }}</x-input-label>
                        <select id="category" name="category">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($article->category->id == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <x-input-label for="tags">{{ __('Tags') }}</x-input-label>
                        <select id="tags" name="tags[]" multiple>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @selected($article->tags->contains($tag))>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </form>
                    <script>
                        tinymce.init({
                            selector: 'textarea',
                            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                        });
                    </script>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
