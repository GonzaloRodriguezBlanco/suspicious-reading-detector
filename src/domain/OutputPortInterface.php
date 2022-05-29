<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain;

use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;

interface OutputPortInterface
{
    /**
     * @param Collection<Reading> $suspiciousReadings
     * @return void
     */
    public function setResult(Collection $suspiciousReadings): void;
}