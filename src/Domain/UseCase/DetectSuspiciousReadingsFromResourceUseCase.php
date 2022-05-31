<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\InputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\Factory\ClientRepositoryFactoryInterface;
use RuntimeException;

class DetectSuspiciousReadingsFromResourceUseCase implements InputPortInterface
{
    private string $uri;

    private ClientRepositoryFactoryInterface $factory;

    /**
     * @param ClientRepositoryFactoryInterface $factory
     */
    public function __construct(ClientRepositoryFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function setParams(string $uri): InputPortInterface
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return Collection<Reading>
     */
    public function execute(): Collection
    {
        $this->checkParams();

        $repository = $this->factory->create($this->uri);

        $clients = $repository->findAllClientsFromUri($this->uri);

        $suspiciousReadingsArray = [];

        foreach ($clients as $client) {
            foreach ($client->detectSuspiciousReadings() as $reading) {
                $suspiciousReadingsArray[] = $reading;
            }
        }

        return new ArrayCollection($suspiciousReadingsArray);
    }

    private function checkParams(): void
    {
        if (!isset($this->uri)){
            throw new RuntimeException("Parameter uri MUST be set before execute DetectSuspiciousReadingsFromResourceUseCase");
        }
    }
}