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
     * @RateLimit(limit=1, period=15)
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

    // TODO: Create a route to handle Twilio POST request for updates to message status (requires setting statusCallback when sending the message)
    // See for details on statusCallback: https://www.twilio.com/docs/sms/api/message-resource#create-a-message-resource
    // And for the request body format: https://www.twilio.com/docs/sms/twiml#request-parameters
    // Not rate limited
    // Uses a new queue to queue up changes or just updates the db from here?
    // How to make this work with dev setup?
}