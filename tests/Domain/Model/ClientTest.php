<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Tests;

use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Status;
use \DateTime;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testClientWithOneSuspiciousLowerReading(): void
    {
        $expectedSuspiciousReadingsCollectionSize = 1;
        $expectedSuspiciousReadingValue = 3564;

        $client = new Client("583ef6329d7b9");
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

        $actual = $client->detectSuspiciousReadings();
        $actualCount = $actual->count();
        self::assertSame($expectedSuspiciousReadingsCollectionSize, $actualCount, sprintf("Count should be %d, but it was %d", $expectedSuspiciousReadingsCollectionSize, $actualCount));

        $actualSuspiciousValue = $actual->first()->getValue();
        self::assertSame($expectedSuspiciousReadingValue, $actualSuspiciousValue, sprintf("Suspicious value should be %d, but it was %d", $expectedSuspiciousReadingValue, $actualSuspiciousValue));
    }

    public function testClientWithoutSuspiciousReadings(): void
    {
        $expectedSuspiciousReadingsCollectionSize = 0;

        $client = new Client("583ef6329d81f");
        $client
            ->addReading(new Reading(new DateTime('2016-01'), 39760, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-02'), 38785, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-03'), 37519, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-04'), 39028, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-05'), 39469, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-06'), 37463, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-07'), 37152, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-08'), 37756, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-09'), 37398, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-10'), 37770, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-11'), 38948, Status::Unchecked))
            ->addReading(new Reading(new DateTime('2016-12'), 37342, Status::Unchecked));

        $actual = $client->detectSuspiciousReadings();
        $actualCount = $actual->count();
        self::assertSame($expectedSuspiciousReadingsCollectionSize, $actualCount, sprintf("Count should be %d, but it was %d", $expectedSuspiciousReadingsCollectionSize, $actualCount));
    }

    public function testClientWithTwoSuspiciousReadingsHigherAndLower(): void
    {
        $expectedSuspiciousReadingsCollectionSize = 2;
        $expectedSuspiciousLowerReadingValue = 7759;
        $expectedSuspiciousHigherReadingValue = 162078;

        $client = new Client("583ef6329d89b");
        $client
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

        $actual = $client->detectSuspiciousReadings();
        $actualCount = $actual->count();
        self::assertSame($expectedSuspiciousReadingsCollectionSize, $actualCount, sprintf("Count should be %d, but it was %d", $expectedSuspiciousReadingsCollectionSize, $actualCount));

        $firstSuspiciousValue = $actual->first()->getValue();
        $secondSuspiciousValue = $actual->next()->getValue();

        $actualSuspiciousLowerValue = $firstSuspiciousValue;
        $actualSuspiciousHigherValue = $secondSuspiciousValue;
        if ($firstSuspiciousValue > $secondSuspiciousValue) {
            $actualSuspiciousLowerValue = $secondSuspiciousValue;
            $actualSuspiciousHigherValue = $firstSuspiciousValue;
        }
        self::assertSame($expectedSuspiciousLowerReadingValue, $actualSuspiciousLowerValue, sprintf("Suspicious lower value should be %d, but it was %d", $expectedSuspiciousLowerReadingValue, $actualSuspiciousLowerValue));
        self::assertSame($expectedSuspiciousHigherReadingValue, $actualSuspiciousHigherValue, sprintf("Suspicious higher value should be %d, but it was %d", $expectedSuspiciousHigherReadingValue, $actualSuspiciousHigherValue));

    }
}