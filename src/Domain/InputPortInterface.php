<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain;

use Doctrine\Common\Collections\Collection;

interface InputPortInterface
{
    public function setParams(String $uri): InputPortInterface;
    public function execute(): Collection;
}