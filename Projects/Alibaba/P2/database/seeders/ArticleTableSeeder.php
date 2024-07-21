<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id
        ]);

        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id
        ]);

        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id
        ]);

        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id
        ]);

        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id
        ]);

        Article::create([
            'title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sapien faucibus et molestie ac feugiat sed lectus vestibulum. Enim nunc faucibus a pellentesque sit amet porttitor eget dolor. Viverra justo nec ultrices dui. Pharetra diam sit amet nisl suscipit. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Quam viverra orci sagittis eu volutpat odio facilisis. Mi proin sed libero enim sed faucibus turpis. Leo integer malesuada nunc vel. Mi proin sed libero enim sed faucibus. Sed libero enim sed faucibus turpis in eu. Sodales neque sodales ut etiam sit amet nisl purus in. Maecenas pharetra convallis posuere morbi leo urna molestie. Ut tortor pretium viverra suspendisse. Aenean euismod elementum nisi quis eleifend quam adipiscing vitae proin. Nam libero justo laoreet sit amet. Id nibh tortor id aliquet lectus proin nibh nisl. Sem nulla pharetra diam sit amet nisl suscipit. Tortor dignissim convallis aenean et tortor at risus.',
            'author_name' => User::factory()->create()->name,
            'file' => '/cover/default.jpg',
            'is_published' => true,
            'user_id' => User::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
        ]);

    }
}
