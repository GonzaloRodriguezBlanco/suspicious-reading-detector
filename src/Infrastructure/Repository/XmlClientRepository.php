<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\XmlReadingMapper;

class XmlClientRepository implements ClientRepositoryPortInterface
{

    private XmlReadingMapper $mapper;

    /**
     * @param XmlReadingMapper $mapper
     */
    public function __construct(XmlReadingMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @throws Exception
     */
    public function findAllClientsFromUri($uri): Collection
    {
        $xmlReadings = simplexml_load_string(file_get_contents(realpath($uri)));

        $clients = new ArrayCollection();
        $counter = 0;
        $client = null;
        foreach ($xmlReadings as $xmlReading) {
            $reading = $this->mapper->toDomain($xmlReading);
            if ($counter === 0) {
                $client = $reading->getClient();
            }
            $client->addReading($reading);
            $counter++;
            if ($counter === 11) {
                $clients->add($client);
                $counter = 0;
            }
        }

        return $clients;
    }
}