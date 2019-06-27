<?php

namespace App\Controller;

use App\Entity\RabbitMq\TwilioUpdateCallbackBody;
use App\Producer\SmsSendProducer;
use App\Producer\SmsUpdateProducer;
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
     * @param SmsSendProducer $smsProducer
     * @param SmsMessageFormBuilder $formBuilder
     * @return Response
     */
    public function sendMessage(Request $request, MessageSerializationService $messageSerializationService, SmsSendProducer $smsProducer, SmsMessageFormBuilder $formBuilder)
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

    /*
     * @Route("/twilio-callback", methods={"POST"})
     */
    public function messageStatusCallback(Request $request, MessageSerializationService $messageSerializationService, SmsUpdateProducer $smsUpdateProducer): Response
    {
        // TODO test this with twilio callback - work out how to do this on dev machine first
        /** @var TwilioUpdateCallbackBody $updateBody */
        $updateBody = $messageSerializationService->getDeserializedObject($request->getContent(), TwilioUpdateCallbackBody::class);
        $smsUpdateProducer->publish($messageSerializationService->getSerializedObject($updateBody));
        return new Response();
    }
}