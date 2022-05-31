<?php

use GonzaloRodriguez\SuspiciousReadingDetector\Domain\InputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\DetectSuspiciousReadingsFromResourceUseCase;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\Factory\ClientRepositoryFactoryInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Factory\ClientRepositoryFactory;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\CsvReadingMapper;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\XmlReadingMapper;

return [
    ClientRepositoryFactoryInterface::class => DI\create(ClientRepositoryFactory::class)
        ->constructor(
            DI\get(CsvReadingMapper::class),
            DI\get(XmlReadingMapper::class)
        ),
    InputPortInterface::class => DI\create(DetectSuspiciousReadingsFromResourceUseCase::class)
        ->constructor(
            DI\get(ClientRepositoryFactoryInterface::class)
        ),
    CsvReadingMapper::class => DI\create(CsvReadingMapper::class),
    XmlReadingMapper::class => DI\create(XmlReadingMapper::class),
];