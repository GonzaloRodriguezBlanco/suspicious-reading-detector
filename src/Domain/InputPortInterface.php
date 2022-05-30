<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain;

interface InputPortInterface
{
    public function setParams(String $uri): InputPortInterface;
    public function execute(): void;
}