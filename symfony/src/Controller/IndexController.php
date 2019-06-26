<?php

namespace App\Controller;

use App\Producer\SmsProducer;
use App\Service\MessageSerializationService;
use Noxlogic\RateLimitBundle\Annotation\RateLimit;
use App\Entity\RabbitMq\SmsMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    // TODO Create a route to serve form

    /**
     * @RateLimit(limit=1, period=15)
     * @Route("/", name="postMessage", methods={"POST"})
     * @param Request $request
     * @param MessageSerializationService $messageSerializationService
     * @param SmsProducer $smsProducer
     * @return Response
     */
    public function postMessage(Request $request, MessageSerializationService $messageSerializationService, SmsProducer $smsProducer)
    {
        /** @var SmsMessage $message */
        $message = $messageSerializationService->getDeserializedObject($request->getContent(), SmsMessage::class);
        // TODO check body is valid, recipient is valid
        $smsProducer->publish($messageSerializationService->getSerializedObject($message));
        return new Response("{$message->getBody()} ({$message->getRecipient()})");
    }

    // TODO: Create a route to handle Twilio POST request for updates to message status (requires setting statusCallback when sending the message)
    // See for details on statusCallback: https://www.twilio.com/docs/sms/api/message-resource#create-a-message-resource
    // And for the request body format: https://www.twilio.com/docs/sms/twiml#request-parameters
    // Not rate limited
    // Uses a new queue to queue up changes or just updates the db from here?
    // How to make this work with dev setup?
}