<?php

namespace Coderjerk\Cupsets;

use Predis\Client;

class Cache
{
    public static function redis(): Client
    {
        return new Client([
            'scheme' => $_ENV['REDIS_SCHEME'],
            'host' => $_ENV['REDIS_HOST'],
            'port' => $_ENV['REDIS_PORT'],
        ]);
    }

    public static function get($key)
    {
        $data = self::redis()->get($key);
        if ($data !== null) {
            return unserialize($data);
        }
        return null;
    }

    public static function set($key, $data, $ttl = 3600): void
    {
        $data = serialize($data);
        self::redis()->setex($key, $ttl, $data);
    }

    public function delete($key): void
    {
        self::redis()->del($key);
    }
}
