<?php

namespace App\Controller;

use App\Entity\SmsMessage;
use App\Repository\SmsMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history", methods={"GET"})
     * @param SmsMessageRepository $messageRepository
     * @return Response
     */
    public function history(SmsMessageRepository $messageRepository)
    {
        return new Response(json_encode(
            array_map(function (SmsMessage $message) {return $message->serialise();}, $messageRepository->findAll())
        ));
    }
}