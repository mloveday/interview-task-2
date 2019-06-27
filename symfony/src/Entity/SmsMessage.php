<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmsMessageRepository")
 */
class SmsMessage
{
    const STATUS_QUEUED = 'queued';
    const STATUS_SENT = 'sent';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_UNDELIVERED = 'undelivered';
    const STATUS_FAILED = 'failed';

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

    /**
     * @ORM\Column(type="string", length=11, columnDefinition="enum('queued', 'sent', 'delivered', 'undelivered', 'failed')")
     */
    private $status;

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

    public function getTimestampString(): string
    {
        return $this->getTimestampSent()->format('d/m/Y H:i:s');
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }
}
