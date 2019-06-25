<?php

namespace App\Controller;

use Noxlogic\RateLimitBundle\Annotation\RateLimit;
use Predis\Client as RedisClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    const KEY = 'test-key';
    const TEST_DATA = 'Hello world!';
    const TTL = 10;

    /**
     * @RateLimit(limit=1, period=5)
     * @Route("/", name="index")
     */
    public function index(RedisClient $redisClient)
    {
        if ($redisClient->exists(self::KEY) === 0) {
            $redisClient->setex(self::KEY, self::TTL, self::TEST_DATA);
            $value = $redisClient->get(self::KEY);
            return new Response($value . " (set)");
        }
        $value = $redisClient->get(self::KEY);
        return new Response($value . " (cached)");
    }
}