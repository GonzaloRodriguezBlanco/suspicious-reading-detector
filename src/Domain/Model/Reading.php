<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model;


use DateTime;

class Reading
{
    private DateTime $period;
    private int $value;
    private Status $status;
    private Client $client;

    /**
     * @param DateTime $period
     * @param int $value
     * @param Status $status
     */
    public function __construct(DateTime $period, int $value, Status $status)
    {
        $this->period = $period;
        $this->value = $value;
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getPeriod(): DateTime
    {
        return $this->period;
    }

    /**
     * @param DateTime $period
     * @return Reading
     */
    public function setPeriod(DateTime $period): Reading
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return Reading
     */
    public function setValue(int $value): Reading
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return Reading
     */
    public function setStatus(Status $status): Reading
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Reading
     */
    public function setClient(Client $client): Reading
    {
        $this->client = $client;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            "%s | %s | %d | %d",
            $this->client->getId(),
            $this->getPeriod()->format('M'),
            $this->value,
            $this->client->getMedian()
        );

    }


}