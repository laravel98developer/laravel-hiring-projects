<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a list of posts belong to the category
     */
    public function category(string $id): View
    {
        return view('category', [
            'category' => Category::find($id),
            'articles' => Category::find($id)->articles()->where('is_published', true)->paginate(env('PAGINATE_NUM')),
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Category::create([
            'name' => $request->input('name')
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $category = Category::all()->find($id);

        return view('categories.show', [
            'category' => $category,
            'articles' =>  $category->articles()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('categories.edit', [
            'category' => Category::all()->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Category::all()->find($id)->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Category::all()->find($id)->delete();

        return redirect()->route('categories.index');
    }
}
