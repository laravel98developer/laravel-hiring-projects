<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::with('tags.categories')->orderBy('created_at', 'asc')->paginate(100);
        return response()->json(['posts' => $posts]);
    }
}
