<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector\Application\Command;

use GonzaloRodriguez\SuspiciousReadingDetector\Domain\InputPortInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:detect-suspicious-readings',
    description: 'Detect suspicious readings.'
)]
class DetectSuspiciousReadingsFromResourceCommand extends Command
{

    private InputPortInterface $inputPort;


    public function __construct(InputPortInterface $inputPort)
    {
        $this->inputPort = $inputPort;
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

        $suspiciousReadings = $this->inputPort->setParams($uri)->execute();

        $output->writeln('Client | Month | Suspicious | Median');

        foreach ($suspiciousReadings as $reading) {
            $output->writeln($reading);
        }

        $output->writeln(['',
            '=======================================',
            'Resource URI: '. $uri,
            'Suspicious readings Total: ' . $suspiciousReadings->count(),
        ]);

        return Command::SUCCESS;
    }
}