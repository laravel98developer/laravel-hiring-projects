<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Post;
use  App\Models\Tag;
use  App\Models\Category;
use App\Services\Elastic;
use App\Jobs\SendSmsJob;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cap = 1000000;
        $chunk = 1000;
        for($i = 0;$i < $cap ;$i += $chunk) {
            try {
                //create post
                $posts = Post::factory()->count($chunk)->create();
                $posts->each(function ($post) {
                    //attach tags
                    $tags = Tag::inRandomOrder()->limit(rand(2, 10))->pluck("id");
                    $post->tags()->sync($tags);
                });

            } catch (\Exception $e) {
                echo $e->getMessage()."\n";
            }
        }

        //sending sms
        dispatch(new SendSmsJob(array(env("OWNER_MOBILE")), "ElasticSearch is updated."));
    }
}
