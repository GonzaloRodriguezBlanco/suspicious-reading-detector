<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Util;

class MedianCalculator
{
    public static function calculate(array $array): int {
        sort($array);
        $count = count($array);

        $even = $count%2 === 0;
        $middle = $count/2;

        // median for odd size array (impar)
        if(!$even) {
            return $array[floor($middle)];
        }

        // median for even size array (par)
        return round(($array[$middle] + $array[$middle - 1])/2);
    }
}