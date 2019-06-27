<?php

namespace App\Entity;

use DateTimeInterface;
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
    private $date_created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_updated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_sent;

    /**
     * @ORM\Column(type="string", length=11, columnDefinition="enum('queued', 'sent', 'delivered', 'undelivered', 'failed')")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sid;

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

    public function getDateCreated(): ?DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated($date_created): self
    {
        $this->date_created = $date_created;
        return $this;
    }

    public function getDateUpdated(): ?DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated($date_updated): self
    {
        $this->date_updated = $date_updated;
        return $this;
    }

    public function getDateSentString(): string
    {
        return $this->getDateSent()->format('d/m/Y H:i:s');
    }

    public function getDateSent(): ?DateTimeInterface
    {
        return $this->date_sent;
    }

    public function setDateSent(DateTimeInterface $timestamp_sent): self
    {
        $this->date_sent = $timestamp_sent;
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

    public function getSid(): string
    {
        return $this->sid;
    }

    public function setSid($sid): self
    {
        $this->sid = $sid;
        return $this;
    }
}
