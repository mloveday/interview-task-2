<?php

namespace App\Consumer;

use App\Service\TwilioClient;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SmsConsumer implements ConsumerInterface
{
    /** @var TwilioClient */
    private $client;
    /** @var string */
    private $senderNumber;

    public function __construct(TwilioClient $client)
    {
        $this->client = $client;
        $this->senderNumber = $_ENV['TWILIO_SENDER_NUMBER'];
    }

    public function execute(AMQPMessage $msg)
    {
        echo $msg->getBody();
        $this->client->messages->create(
            $_ENV['MY_PHONE_NUMBER'], // TODO replace with number from message
            [
                'from' => $this->senderNumber,
                'body' => $msg->getBody(),
            ]
        );
    }

}