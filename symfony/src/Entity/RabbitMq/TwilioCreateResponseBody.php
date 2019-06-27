<?php

namespace App\Entity\RabbitMq;

use DateTime;

class TwilioCreateResponseBody
{
    /** @var string */
    private $to;
    /** @var string */
    private $from;
    /** @var string */
    private $body;
    /** @var DateTime */
    private $dateCreated;
    /** @var DateTime */
    private $dateUpdated;
    /** @var DateTime */
    private $dateSent;
    /** @var string */
    private $sid;
    /** @var string */
    private $status;

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): TwilioCreateResponseBody
    {
        $this->to = $to;
        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function setFrom(string $from): TwilioCreateResponseBody
    {
        $this->from = $from;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): TwilioCreateResponseBody
    {
        $this->body = $body;
        return $this;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): TwilioCreateResponseBody
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function getDateUpdated(): DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(DateTime $dateUpdated): TwilioCreateResponseBody
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    public function getDateSent(): DateTime
    {
        return $this->dateSent;
    }

    public function setDateSent(DateTime $dateSent): TwilioCreateResponseBody
    {
        $this->dateSent = $dateSent;
        return $this;
    }

    public function getSid(): string
    {
        return $this->sid;
    }

    public function setSid(string $sid): TwilioCreateResponseBody
    {
        $this->sid = $sid;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): TwilioCreateResponseBody
    {
        $this->status = $status;
        return $this;
    }

}