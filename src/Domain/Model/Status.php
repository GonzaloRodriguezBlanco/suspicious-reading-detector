<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model;


enum Status
{
    case Unchecked;
    case Suspicious;
    case Passed;
}