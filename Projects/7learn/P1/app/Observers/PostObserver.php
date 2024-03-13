<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\Elastic;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $elastic = new Elastic();
        $params = [
            'index' => 'posts',
            'id' => $post->id,
            'body' => [
                'title' => $post->title,
                'content' => $post->content,
                'status' => $post->status,
                'created_at' => $post->created_at,
                'updated_at' => $post->created_at,
            ]
        ];
        $elastic->index($params);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $elastic = new Elastic();
        $params = [
            'index' => 'posts',
            'id' => $post->id,
            'body' => [
                'title' => $post->title,
                'content' => $post->content,
                'status' => $post->status,
                'created_at' => $post->created_at,
                'updated_at' => $post->created_at,
            ]
        ];
        $elastic->index($params);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $elastic = new Elastic();
        $params = [
            'index' => 'posts',
            'id' => $post->id,
        ];
        $elastic->delete($params);
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
