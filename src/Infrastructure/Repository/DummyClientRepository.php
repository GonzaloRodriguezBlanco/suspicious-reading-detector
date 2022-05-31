<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Infrastructure\Repository;


use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Status;

class DummyClientRepository implements ClientRepositoryPortInterface
{

    public function findAllClientsFromUri($uri): Collection
    {
        $clients = new ArrayCollection();
        $client = new Client("583ef6329d7b8");
        $client
            ->addReading(new Reading(new DateTime('2016-01'), 42451, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-02'), 44279, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-03'), 44055, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-04'), 40953, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-05'), 42566, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-06'), 41216, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-07'), 43597, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-08'), 43324, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-09'), 3564, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-10'), 44459, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-11'), 42997, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-12'), 42600, Status::Unchecked));

        $clients->add($client);

        $anotherClient = new Client("583ef6329d89b");
        $anotherClient
            ->addReading(new Reading(new DateTime('2016-01'), 59700, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-02'), 61524, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-03'), 59532, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-04'), 62011, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-05'), 58325, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-06'), 58386, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-07'), 59355, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-08'), 59681, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-09'), 162078, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-10'), 7759, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-11'), 60952, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-12'), 56894, Status::Unchecked));

        $clients->add($anotherClient);

        return $clients;
    }
}