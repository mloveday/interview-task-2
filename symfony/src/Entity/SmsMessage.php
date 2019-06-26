<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmsMessageRepository")
 */
class SmsMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=13)
     */
    private $recipient;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp_sent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getTimestampSent(): ?\DateTimeInterface
    {
        return $this->timestamp_sent;
    }

    public function setTimestampSent(\DateTimeInterface $timestamp_sent): self
    {
        $this->timestamp_sent = $timestamp_sent;
        return $this;
    }

    public function serialise()
    {
        return (object) [
            'recipient' => $this->getRecipient(),
            'body' => $this->getBody(),
            'timestamp_sent' => $this->getTimestampSent(),
        ];
    }
}
