<?php

namespace App\Consumer;

use App\Entity\RabbitMq\SmsMessageRequest;
use App\Entity\RabbitMq\TwilioCreateResponseBody;
use App\Producer\SmsStoreProducer;
use App\Producer\SmsUpdateProducer;
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
    /** @var SmsStoreProducer */
    private $smsStoreProducer;

    public function __construct(TwilioClient $client, MessageSerializationService $messageSerializationService, SmsStoreProducer $smsStoreProducer)
    {
        $this->client = $client;
        $this->serializationService = $messageSerializationService;
        $this->senderNumber = $_ENV['TWILIO_SENDER_NUMBER'];
        $this->smsStoreProducer = $smsStoreProducer;
    }

    public function execute(AMQPMessage $msg)
    {
        /** @var SmsMessageRequest $message */
        $message = $this->serializationService->getDeserializedObject($msg->getBody(), SmsMessageRequest::class);
        echo "Sending SMS to {$message->getRecipient()}: {$message->getBody()}\n";
        // TODO handle exception when sending messages
        $response = $this->client->messages->create(
            $message->getRecipient(),
            [
                'from' => $this->senderNumber,
                'body' => $message->getBody(),
            ]
        );
        echo $response;
        echo "\n";
        $queueMessage = (new TwilioCreateResponseBody())
            ->setStatus($response->status)
            ->setBody($response->body)
            ->setDateCreated($response->dateCreated)
            ->setDateSent($response->dateSent)
            ->setDateUpdated($response->dateUpdated)
            ->setFrom($response->from)
            ->setTo($response->to)
            ->setSid($response->sid);
        echo $this->serializationService->getSerializedObject($queueMessage);
        echo "\n";
        $this->smsStoreProducer->publish($this->serializationService->getSerializedObject($queueMessage));
    }

}