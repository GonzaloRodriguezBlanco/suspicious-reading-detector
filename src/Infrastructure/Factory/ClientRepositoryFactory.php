<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Factory;

use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\Factory\ClientRepositoryFactoryInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\CsvReadingMapper;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\XmlReadingMapper;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository\CsvClientRepository;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository\DummyClientRepository;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository\XmlClientRepository;

class ClientRepositoryFactory implements ClientRepositoryFactoryInterface
{
    private CsvReadingMapper $csvReadingMapper;
    private XmlReadingMapper $xmlReadingMapper;

    /**
     * @param CsvReadingMapper $csvReadingMapper
     * @param XmlReadingMapper $xmlReadingMapper
     */
    public function __construct(CsvReadingMapper $csvReadingMapper, XmlReadingMapper $xmlReadingMapper)
    {
        $this->csvReadingMapper = $csvReadingMapper;
        $this->xmlReadingMapper = $xmlReadingMapper;
    }

    public function create(string $uri): ClientRepositoryPortInterface {
        $strategy = substr($uri, -3);

        if ('csv' === $strategy) {
            return new CsvClientRepository($this->csvReadingMapper);
        }

        if ('xml' === $strategy) {
            return new XmlClientRepository($this->xmlReadingMapper);
        }

        return new DummyClientRepository();
    }
}