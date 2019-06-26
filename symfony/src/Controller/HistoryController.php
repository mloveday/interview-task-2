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
        return $this->render('history/history.html.twig', ['messages' => $messageRepository->findAllSortedByTimeDesc()]);
    }
}