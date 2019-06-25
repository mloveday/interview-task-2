<?php

namespace App\Listener;

use Noxlogic\RateLimitBundle\Events\GenerateKeyEvent;

class RateLimitGenerateKeyListener
{
    public function onGenerateKey(GenerateKeyEvent $event)
    {
        $request = $event->getRequest();
        $event->addToKey($request->getClientIp());
    }
}