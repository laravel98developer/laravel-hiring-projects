<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a list of posts belong to the category
     */
    public function tag(string $id): View
    {
        return view('tag', [
            'tag' => Tag::find($id),
            'articles' => Tag::find($id)->articles()->where('is_published', true)->paginate(env('PAGINATE_NUM')),
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('tags.index', [
            'tags' => Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Tag::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $tag = Tag::all()->find($id);

        return view('tags.show', [
            'tag' => $tag,
            'posts' => $tag->articles()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('tags.edit', [
            'tag' => Tag::all()->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Tag::all()->find($id)->update([
            'name' => $request->input('name')
        ]);

        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Tag::all()->find($id)->delete();

        return redirect()->route('tags.index');
    }
}
