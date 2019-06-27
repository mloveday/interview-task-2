<?php

namespace App\Consumer;

use App\Entity\RabbitMq\TwilioCreateResponseBody;
use App\Entity\RabbitMq\TwilioUpdateCallbackBody;
use App\Repository\SmsMessageRepository;
use App\Service\MessageSerializationService;
use App\Service\PersistenceService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SmsUpdateConsumer implements ConsumerInterface
{
    /** @var MessageSerializationService */
    private $serializationService;
    /** @var PersistenceService */
    private $persistenceService;
    /** @var SmsMessageRepository */
    private $messageRepository;

    public function __construct(MessageSerializationService $messageSerializationService, PersistenceService $persistenceService, SmsMessageRepository $messageRepository)
    {
        $this->serializationService = $messageSerializationService;
        $this->persistenceService = $persistenceService;
        $this->messageRepository = $messageRepository;
    }

    public function execute(AMQPMessage $msg)
    {
        /** @var TwilioUpdateCallbackBody $message */
        $message = $this->serializationService->getDeserializedObject($msg->getBody(), TwilioCreateResponseBody::class);
        echo "Updating SMS with sid {$message->getSid()}: {$message->getStatus()}\n";
        // TODO handle exception when storing messages
        $existingMessage = $this->messageRepository->findBySid($message->getSid());
        $this->persistenceService->persist(
            $existingMessage
            ->setDateCreated($message->getDateCreated())
            ->setDateUpdated($message->getDateUpdated())
            ->setDateSent($message->getDateSent())
            ->setStatus($message->getStatus())
        );
    }

}