<?php

namespace App\Entity\RabbitMq;

class SmsMessage
{
    /** @var string */
    private $recipient;
    /** @var string */
    private $body;

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     * @return SmsMessage
     */
    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return SmsMessage
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
}