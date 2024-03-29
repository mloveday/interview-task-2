<?php

namespace App\Consumer;

use App\Entity\RabbitMq\TwilioCreateResponseBody;
use App\Entity\SmsMessage;
use App\Service\MessageSerializationService;
use App\Service\PersistenceService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SmsStoreConsumer implements ConsumerInterface
{
    /** @var MessageSerializationService */
    private $serializationService;
    /** @var PersistenceService */
    private $persistenceService;

    public function __construct(MessageSerializationService $messageSerializationService, PersistenceService $persistenceService)
    {
        $this->serializationService = $messageSerializationService;
        $this->persistenceService = $persistenceService;
    }

    public function execute(AMQPMessage $msg)
    {
        echo $msg->getBody();
        /** @var TwilioCreateResponseBody $message */
        $message = $this->serializationService->getDeserializedObject($msg->getBody(), TwilioCreateResponseBody::class);
        echo "Storing SMS to {$message->getTo()}: {$message->getBody()}\n";
        // TODO handle exception when storing messages
        $this->persistenceService->persist((new SmsMessage())
            ->setRecipient($message->getTo())
            ->setBody($message->getBody())
            ->setDateSent($message->getDateSent())
            ->setDateCreated($message->getDateCreated())
            ->setDateSent($message->getDateSent())
            ->setStatus($message->getStatus())
            ->setSid($message->getSid())
        );
    }

}