<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper;

use DateTime;
use Exception;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Status;

class CsvReadingMapper
{
    private const CLIENT = 0;
    private const DATE = 1;
    private const READING = 2;

    /**
     * @throws Exception
     */
    public function toDomain(array $csvReading): Reading {
        $domainClient = new Client($csvReading[self::CLIENT]);
        $reading = new Reading(new DateTime($csvReading[self::DATE]), $csvReading[self::READING], Status::Unchecked);
        $reading->setClient($domainClient);
        return $reading;
    }
}