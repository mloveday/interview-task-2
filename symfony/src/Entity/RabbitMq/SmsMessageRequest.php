<?php

namespace App\Entity\RabbitMq;

use Symfony\Component\Validator\Constraints as Assert;

class SmsMessageRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^(\+44|07)\d{9}$/", message="Recipient needs to be a UK mobile number starting 07 or +44 followed by 9 digits, e.g. 07123456789 or +44123456789")
     */
    private $recipient;
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max = 140, maxMessage = "Your message is too long, it must be no more than {{ limit }} characters")
     */
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
     * @return SmsMessageRequest
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
     * @return SmsMessageRequest
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
}