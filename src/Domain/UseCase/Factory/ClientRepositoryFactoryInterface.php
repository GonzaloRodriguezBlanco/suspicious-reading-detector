<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\Factory;

use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;

interface ClientRepositoryFactoryInterface
{
    public function create(string $uri): ClientRepositoryPortInterface;
}