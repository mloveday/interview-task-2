<?php

namespace App\Controller;

use App\Producer\SmsProducer;
use Noxlogic\RateLimitBundle\Annotation\RateLimit;
use Predis\Client as RedisClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    const KEY = 'test-key';
    const TEST_DATA = 'Hello world!';
    const TTL = 10;

    /**
     * @RateLimit(limit=10, period=1)
     * @Route("/", name="index")
     */
    public function index(RedisClient $redisClient, SmsProducer $smsProducer)
    {
        if ($redisClient->exists(self::KEY) === 0) {
            $redisClient->setex(self::KEY, self::TTL, self::TEST_DATA);
            $value = $redisClient->get(self::KEY);
            $smsProducer->publish($value . " (set)");
            return new Response($value . " (set)");
        }
        $value = $redisClient->get(self::KEY);
        $smsProducer->publish($value . " (cached)");
        return new Response($value . " (cached)");
    }
}