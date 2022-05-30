<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase;

use Doctrine\Common\Collections\ArrayCollection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\InputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\OutputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use RuntimeException;

class DetectSuspiciousReadingsFromResourceUseCase implements InputPortInterface
{
    private string $uri;

    private ClientRepositoryPortInterface $repository;
    private OutputPortInterface $outputPort;

    /**
     * @param ClientRepositoryPortInterface $repository
     * @param OutputPortInterface $outputPort
     */
    public function __construct(ClientRepositoryPortInterface $repository, OutputPortInterface $outputPort)
    {
        $this->repository = $repository;
        $this->outputPort = $outputPort;
    }

    public function setParams(string $uri): InputPortInterface
    {
        $this->uri = $uri;
        return $this;
    }

    public function execute(): void
    {
        $this->checkParams();

        $clients = $this->repository->findAllClientsFromUri($this->uri);

        $suspiciousReadingsArray = [];

        foreach ($clients as $client) {
            foreach ($client->detectSuspiciousReadings() as $reading) {
                $suspiciousReadingsArray[] = $reading;
            }
        }

        $suspiciousReadings = new ArrayCollection($suspiciousReadingsArray);

        $this->outputPort->setResult($suspiciousReadings);
    }

    private function checkParams(): void
    {
        if (!isset($this->uri)){
            throw new RuntimeException("Parameter uri MUST be set before execute DetectSuspiciousReadingsFromResourceUseCase");
        }
    }
}