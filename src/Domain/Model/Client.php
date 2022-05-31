<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Util\MedianCalculator;

class Client
{
    private String $id;

    /** @var Collection<Reading> $readings */
    private Collection $readings;

    private int $median;


    /**
     * @param String $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->readings = new ArrayCollection();
    }

    /**
     * @return String
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param String $id
     * @return Client
     */
    public function setId(string $id): Client
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Collection<Reading>
     */
    public function getReadings(): Collection
    {
        return $this->readings;
    }

    /**
     * @param Collection<Reading> $readings
     * @return Client
     */
    public function setReadings(Collection $readings): Client
    {
        $this->readings = $readings;
        return $this;
    }

    public function addReading(Reading $reading): Client
    {
        $this->readings->add($reading);
        $reading->setClient($this);

        return $this;
    }

    public function removeReading(Reading $reading): Client
    {
        $this->readings->remove($reading);

        return $this;
    }

    public function getMedian(): int {
        if (isset($this->median)) {
            return $this->median;
        }

        $readings = [];
        foreach ($this->readings as $reading) {
            $readings[] = $reading->getValue();
        }

        $this->median = MedianCalculator::calculate($readings);

        return $this->median;
    }

    /**
     * @return Collection<Reading>
     */
    public function detectSuspiciousReadings(): Collection {
        $median = $this->getMedian();

        return $this->readings->filter(static function ($reading) use ($median) {
            $value = $reading->getValue();
            $reading->setStatus(Status::Passed);
            $isSuspicious = $value < $median * 0.5 || $value > $median * 1.5;

            if ($isSuspicious) {
                $reading->setStatus(Status::Suspicious);
            }

            return $isSuspicious;
        });
    }
}