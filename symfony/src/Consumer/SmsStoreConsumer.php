<?php

namespace App\Consumer;

use App\Entity\RabbitMq\SmsMessageRequest;
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
    /** @var string */
    private $senderNumber;

    public function __construct(MessageSerializationService $messageSerializationService, PersistenceService $persistenceService)
    {
        $this->serializationService = $messageSerializationService;
        $this->persistenceService = $persistenceService;
        $this->senderNumber = $_ENV['TWILIO_SENDER_NUMBER'];
    }

    public function execute(AMQPMessage $msg)
    {
        // TODO handle exceptions deserializing data (this should not happen as it's converted to an SmsMessage object before sending)
        /** @var SmsMessageRequest $message */
        $message = $this->serializationService->getDeserializedObject($msg->getBody(), SmsMessageRequest::class);
        echo "Storing SMS to {$message->getRecipient()}: {$message->getBody()}\n";
        // TODO handle exception when storing messages
        $this->persistenceService->persist((new SmsMessage())
            ->setRecipient($message->getRecipient())
            ->setBody($message->getBody())
            ->setTimestampSent(new \DateTime())
            ->setStatus(SmsMessage::STATUS_QUEUED)
        );
    }

}