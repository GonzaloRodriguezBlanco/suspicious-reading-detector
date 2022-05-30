<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\application\command;

use DI\Annotation\Inject;
use Doctrine\Common\Collections\Collection;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\InputPortInterface;
use GonzaloRodriguez\SuspiciousReadingDetector\Domain\OutputPortInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:detect-suspicious-readings',
    description: 'Detect suspicious readings.'
)]
class DetectSuspiciousReadingsFromResourceCommand extends Command implements OutputPortInterface
{

    /**
     * @Inject
     * @var InputPortInterface
     */
    private InputPortInterface $inputPort;

    private Collection $suspiciousReadings;


    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // configure an argument
            ->addArgument('uri', InputArgument::REQUIRED, 'The uri of the resource')
        ;
    }

// ...
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Suspicious Reading Detector',
            '===========================',
            '',
        ]);

        $uri = $input->getArgument('uri');

        // retrieve the argument value using getArgument()
        $output->writeln('Uri: '. $uri);

        $this->inputPort->setParams($uri)->execute();

        $output->writeln($this->suspiciousReadings);

        return Command::SUCCESS;
    }

    public function setResult(Collection $suspiciousReadings): void
    {
        $this->suspiciousReadings = $suspiciousReadings;
    }
}