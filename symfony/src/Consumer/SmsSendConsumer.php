<?php

namespace App\Consumer;

use App\Entity\RabbitMq\SmsMessageRequest;
use App\Service\MessageSerializationService;
use App\Service\TwilioClient;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SmsSendConsumer implements ConsumerInterface
{
    /** @var TwilioClient */
    private $client;
    /** @var MessageSerializationService */
    private $serializationService;
    /** @var string */
    private $senderNumber;

    public function __construct(TwilioClient $client, MessageSerializationService $messageSerializationService)
    {
        $this->client = $client;
        $this->serializationService = $messageSerializationService;
        $this->senderNumber = $_ENV['TWILIO_SENDER_NUMBER'];
    }

    public function execute(AMQPMessage $msg)
    {
        // TODO handle exceptions deserializing data (this should not happen as it's converted to an SmsMessage object before sending)
        /** @var SmsMessageRequest $message */
        $message = $this->serializationService->getDeserializedObject($msg->getBody(), SmsMessageRequest::class);
        echo "Sending SMS to {$message->getRecipient()}: {$message->getBody()}\n";
        // TODO handle exception when sending messages
        $this->client->messages->create(
            $message->getRecipient(),
            [
                'from' => $this->senderNumber,
                'body' => $message->getBody(),
            ]
        );
    }

}