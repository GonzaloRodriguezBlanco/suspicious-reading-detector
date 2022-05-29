<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Tests;

use GonzaloRodriguez\SuspiciousReadingDetector\Util\MedianCalculator;
use PHPUnit\Framework\TestCase;

class MedianCalculatorTest extends TestCase
{
    public function testCalculateMedianForArrayWithOddElementsNumber(): void {
        $array= [ 3, 2, 1, 0, 4];

        $expected = 2;

        $actual = MedianCalculator::calculate($array);

        $this->assertSame($expected, $actual, sprintf("Median should be %d, but it was %d", $expected, $actual));
    }

    public function testCalculateMedianForArrayWithEvenElementsNumber(): void {
        $array= [ 3, 2, 1, 0, 4, 5];

        $expected = 3;

        $actual = MedianCalculator::calculate($array);

        $this->assertSame($expected, $actual, sprintf("Median should be %d, but it was %d", $expected, $actual));
    }
}