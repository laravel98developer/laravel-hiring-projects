<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Elastic;
use App\Jobs\SendSmsJob;

class ElasticSyncer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-syncer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Afrer runing this command ElasticSearch index and database should be sync togheder.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::chunk(1000, function (Collection $posts) {
            try {
                $elastic = new Elastic();
                foreach ($posts as $post) {
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
                    echo $post->id.".".$post->title." is tranfered.\n";
                }
            } catch (\Exception $e) {
                echo $e->getMessage()."\n";
            }

        });
        //sending sms
        dispatch(new SendSmsJob(array(env("OWNER_MOBILE")), "Now elasticsearch and database are synced togheder."));
    }
}
