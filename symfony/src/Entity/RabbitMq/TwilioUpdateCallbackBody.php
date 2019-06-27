<?php

namespace App\Entity\RabbitMq;

use DateTime;

class TwilioUpdateCallbackBody
{
    /** @var string */
    private $sid;
    /** @var DateTime */
    private $dateCreated;
    /** @var DateTime */
    private $dateUpdated;
    /** @var DateTime */
    private $dateSent;
    /** @var string */
    private $status;

    public function getSid(): string
    {
        return $this->sid;
    }

    public function setSid(string $sid): TwilioUpdateCallbackBody
    {
        $this->sid = $sid;
        return $this;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(DateTime $dateCreated): TwilioUpdateCallbackBody
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function getDateUpdated(): DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(DateTime $dateUpdated): TwilioUpdateCallbackBody
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    public function getDateSent(): DateTime
    {
        return $this->dateSent;
    }

    public function setDateSent(DateTime $dateSent): TwilioUpdateCallbackBody
    {
        $this->dateSent = $dateSent;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): TwilioUpdateCallbackBody
    {
        $this->status = $status;
        return $this;
    }
}