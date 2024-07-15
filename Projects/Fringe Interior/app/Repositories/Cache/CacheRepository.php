<?php

namespace App\Repositories\Cache;

use Illuminate\Support\Facades\Cache;

class CacheRepository implements CacheRepositoryInterface
{

    public function getOrSet(string $tags, string $key, callable $closure, $seconds)
    {
        return Cache::tags($tags)->remember($key, $seconds, function () use ($closure) {
            return $closure();
        });
    }

    public function forgetByTag(string $tag){
        Cache::tags($tag)->flush();
    }

    public function forget(string $key)
    {
        return Cache::forget($key);
    }
}
