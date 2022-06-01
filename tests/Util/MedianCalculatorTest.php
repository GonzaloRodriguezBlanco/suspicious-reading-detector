<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Tests;

use GonzaloRodriguez\SuspiciousReadingDetector\Util\Calculator;
use PHPUnit\Framework\TestCase;

class MedianCalculatorTest extends TestCase
{
    public function testCalculateMedianForArrayWithOddElementsNumber(): void {
        $array= [ 3, 2, 1, 0, 4];

        $expected = 2;

        $actual = Calculator::calculateMedian($array);

        $this->assertSame($expected, $actual, sprintf("Median should be %d, but it was %d", $expected, $actual));
    }

    public function testCalculateMedianForArrayWithEvenElementsNumber(): void {
        $array= [ 3, 2, 1, 0, 4, 5];

        $expected = 3;

        $actual = Calculator::calculateMedian($array);

        $this->assertSame($expected, $actual, sprintf("Median should be %d, but it was %d", $expected, $actual));
    }

    public function testCalculateAverageForArray() : void {
        $array = [ 10, 10, 20, 20];

        $expected = 15;

        $actual = Calculator::calculateAverage($array);

        $this->assertSame($expected, $actual, sprintf("Average should be %d, but it was %d", $expected, $actual));
    }
}