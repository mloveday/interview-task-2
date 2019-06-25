<?php

namespace App\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SmsConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        // TODO this needs to handle the (as yet) unsent message, i.e. send via twilio
        echo $msg->getBody();
    }

}