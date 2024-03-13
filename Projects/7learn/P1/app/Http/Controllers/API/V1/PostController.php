<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Elastic;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $from = 0;
        if(is_numeric(request('page')) && request('page') > 1) {
            $from = (request('page') - 1) * 100;
        }

        $filter = array("sort" => ["_score",[ "created_at" => ["order" => "desc","unmapped_type" => "boolean"]]]);

        if (isset($_GET['title'])) {
            $filter['query'] = [ 'match' => ['title' => $_GET['title'] ]];
        }

        $params = [
             "from" => $from,
             "size" => 100,
             'index' => 'posts',
             'body'  => $filter

        ];

        $elastic = new Elastic();
        $posts = $elastic->list($params)->hits->hits;

        return response()->json(['posts' => new PostCollection($posts)]);
    }

    public function show(Post $post): JsonResponse
    {
        $post = Post::with('tags.categories')->find($post->id);
        return response()->json(['post' => $post]);
    }
}
