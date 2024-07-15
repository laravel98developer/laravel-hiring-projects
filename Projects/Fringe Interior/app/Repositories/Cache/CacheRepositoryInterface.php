<?php

namespace App\Repositories\Cache;

interface CacheRepositoryInterface
{
    public function getOrSet(string $tags, string $key, callable $closure, $seconds);

    public function forget(string $key);

    public function forgetByTag(string $tag);
}
