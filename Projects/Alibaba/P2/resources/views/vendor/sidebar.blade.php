<div class="col-span-1">

  <div class="border rounded-md mb-4">
    <div class="bg-slate-200 p-4">Categories</div>
    <div class="p-4">
      <ul class="list-none list-inside">
        @foreach ($categories as $category)
        <li>
          <a href="{{ route('category', ['category' => $category->id]) }}" class="text-blue-500 hover:underline">{{ $category->name }}</a>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="border rounded-md mb-4">
    <div class="bg-slate-200 p-4">Tags</div>
    <div class="p-4">
      @foreach ($tags as $tag)
      <span class="mr-2"><a href="{{ route('tag', ['tag' => $tag->id]) }}" class="text-blue-500 hover:underline">{{ $tag->name }}</a></span>
      @endforeach
    </div>
  </div>
  <div class="border rounded-md mb-4">
    <div class="bg-slate-200 p-4">about</div>
    <div class="p-4">
      <p>
        this project is task based test for Alibaba company
          interview.
      </p>
    </div>
  </div>
  <div class="border rounded-md mb-4">
    <div class="bg-slate-200 p-4">author</div>
    <div class="p-4">
      <p>
        made by ghazal shafiei
      </p>
    </div>
  </div>
</div>
