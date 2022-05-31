<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository;


use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Mapper\CsvReadingMapper;

class CsvClientRepository implements ClientRepositoryPortInterface
{
    private CsvReadingMapper $mapper;

    /**
     * @param CsvReadingMapper $mapper
     */
    public function __construct(CsvReadingMapper $mapper)
    {
        $this->mapper = $mapper;
    }


    public function findAllClientsFromUri($uri): Collection
    {
        $file = fopen(realpath($uri), 'r');

        $clients = new ArrayCollection();
        $counter = 0;
        $client = null;
        $row = 0;
        while (!feof($file)) {
            $csvReading = fgetcsv($file, null,',');
            $row ++;
            if ($row === 1) {
                continue;
            }

            $reading = $this->mapper->toDomain($csvReading);
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

        fclose($file);

        return $clients;
    }
}