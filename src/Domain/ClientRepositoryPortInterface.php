<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain;

use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;

interface ClientRepositoryPortInterface
{
    /**
     * @return Collection<Client> TODO: Substitute this with correct object
     */
    public function findAllClientsFromUri($uri): Collection;
}