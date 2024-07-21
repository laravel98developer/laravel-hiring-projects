<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\s;

class ArticleController extends Controller
{
    /**
     * Display the home page
     */
    public function home(): View
    {
        return view('home', [
            'articles' => Article::where('is_published', true)->paginate(env('PAGINATE_NUM')),
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Display requested article
     */
    public function show(string $id): View
    {
        return view('article', [
            'article' => Article::find($id),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('articles.index', [
            'articles' => Article::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('articles.create', [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $path = '';

        if($request->hasFile('cover')){
        $filenameWithExt = $request->file('cover')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('cover')->getClientOriginalExtension();
        $fileNameToStore = $filename.'-'.time().'.'.$extension;
        $path = $request->file('cover')->storeAs('public', $fileNameToStore);
        }

        $article = Article::create([
            'is_published' => $request->input('is_published') === 'on',
            'title' => $request['title'],
            'content' => $request['content'],
            'author_name' => Auth::user()->name,
            'file' => $path,
            'user_id' => Auth::user()->id,
            'category_id' => $request->input('category') ? Category::find($request->input('category'))->id : 1,
        ]);

        if ($request->input('tags')) {
            foreach ($request->input('tags') as $tag) {
                $article->tags()->attach($tag);
            }
        }

        return redirect()->route('articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('articles.edit', [
            'article' => Article::all()->find($id),
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, string $id): RedirectResponse
    {
        $path = '';
        if($request->hasFile('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $filename.'-'.time().'.'.$extension;
            $path = $request->file('file')->storeAs('public/uploads', $fileNameToStore);
        }
        $article = Article::all()->find($id);
            $article->update([
            'is_published' => $request->input('is_published') === 'on',
            'title' => $request['title'],
            'content' => $request['content'],
            'author_name' => Auth::user()->name,
            'file' => $path,
            'user_id' => Auth::user()->id,
            'category_id' => $request->input('category') ? Category::find($request->input('category'))->id : 1,
        ]);

        $article->tags()->detach();

        //Set tags
        if ($request->input('tags')) {
            foreach ($request->input('tags') as $tag) {
                $article->tags()->attach($tag);
            }
        }

        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $article = Article::all()->find($id);
        $article->delete();

        return redirect()->route('articles.index');
    }
}
