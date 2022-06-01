<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper;

use DateTime;
use Exception;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Status;
use SimpleXMLElement;

class XmlReadingMapper
{
    private const CLIENT = 'clientID';
    private const DATE = 'period';

    /**
     * @throws Exception
     */
    public function toDomain(SimpleXMLElement $xmlReading): Reading {
        $domainClient = new Client($xmlReading[self::CLIENT]);
        $reading = new Reading(new DateTime($xmlReading[self::DATE]), (int) $xmlReading, Status::Unchecked);
        $reading->setClient($domainClient);
        return $reading;
    }
}