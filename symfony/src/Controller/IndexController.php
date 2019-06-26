<?php

namespace App\Controller;

use App\Entity\RabbitMq\SmsMessageRequest;
use App\Producer\SmsProducer;
use App\Service\Form\SmsMessageFormBuilder;
use App\Service\MessageSerializationService;
use Noxlogic\RateLimitBundle\Annotation\RateLimit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @RateLimit(limit=1, period=15, methods="POST")
     * @Route("/", name="sendMessage", methods={"POST"})
     * @param Request $request
     * @param MessageSerializationService $messageSerializationService
     * @param SmsProducer $smsProducer
     * @param SmsMessageFormBuilder $formBuilder
     * @return Response
     */
    public function sendMessage(Request $request, MessageSerializationService $messageSerializationService, SmsProducer $smsProducer, SmsMessageFormBuilder $formBuilder)
    {
        $form = $formBuilder->createSmsMessageForm()->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $smsProducer->publish($messageSerializationService->getSerializedObject($form->getData()));
        }
        return $this->renderFormResponse($form);
    }

    /**
     * @Route("/", name="renderSendMessageForm", methods={"GET"})
     * @param SmsMessageFormBuilder $formBuilder
     * @return Response
     */
    public function renderSendMessageForm(SmsMessageFormBuilder $formBuilder)
    {
        $form = $formBuilder->createSmsMessageForm();
        return $this->renderFormResponse($form);
    }

    /**
     * @param FormInterface $form
     * @return Response
     */
    private function renderFormResponse(FormInterface $form): Response
    {
        return $this->render('index/send-message.html.twig', ['form' => $form->createView()]);
    }

    // TODO: Create a route to handle Twilio POST request for updates to message status (requires setting statusCallback when sending the message)
    // See for details on statusCallback: https://www.twilio.com/docs/sms/api/message-resource#create-a-message-resource
    // And for the request body format: https://www.twilio.com/docs/sms/twiml#request-parameters
    // Not rate limited
    // Uses a new queue to queue up changes or just updates the db from here?
    // How to make this work with dev setup?
}