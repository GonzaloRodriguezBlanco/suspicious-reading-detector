<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain;

use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;

interface ClientRepositoryPortInterface
{
    /**
     * @return Collection<Client>
     */
    public function findAllClientsFromUri($uri): Collection;
}