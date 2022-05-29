<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Client;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Reading;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\Model\Status;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\OutputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\ClientRepositoryPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\UseCase\DetectSuspiciousReadingsFromResourceUseCase;
use PHPUnit\Framework\TestCase;

class DetectSuspiciousReadingsFromResourceUseCaseTest extends TestCase
{
    public function testDetectSuspiciousReadingsInTwoClients(): void {

        $clients = new ArrayCollection();
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

        $clients->add($client);

        $anotherClient = new Client("583ef6329d7b9");
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

        $mockRepository = $this->createMock(ClientRepositoryPortInterface::class);
        $mockRepository->method('findAllClientsFromUri')
            ->willReturn($clients);

        $mockOutput = $this->createMock(OutputPortInterface::class);
        $mockOutput->expects($this->once())
            ->method('setResult')
            ->with($this->callback(function($readings) {
                $expectedReadingValues = [3564, 162078, 7759];
                $assertCount = $readings->count() === 3;

                foreach ($readings as $reading) {
                    $expectedReadingValues = array_filter($expectedReadingValues, static function ($value) use ($reading) {
                        return $value !== $reading->getValue();
                    });
                }

                return $assertCount && empty($expectedReadingValues);
            }));
        $useCase = new DetectSuspiciousReadingsFromResourceUseCase($mockRepository, $mockOutput);
        $useCase->setParams('')->execute();
    }
}