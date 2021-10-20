<?php

namespace App\Command;

use App\Service\CronJobService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class OnApproachCheckCommand extends Command
{
    protected static $defaultName = 'on:approach:check';

    /**
     * @var CronJobService
     */
    private $cronJobService;

    public function __construct(CronJobService $cronJobService)
    {
        parent::__construct();
        $this->cronJobService = $cronJobService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Check if any aircraft is on approach, and if so, changing its status to LANDED.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ioStream = new SymfonyStyle($input, $output);
        $ioStream->title('CHECK AIRCRAFT APPROACH');
        try {
            $this->cronJobService->onApproachCheckAction();
        } catch (\Throwable $e) {
            $ioStream->error('Error occured: '.$e->getMessage());

            return 1;
        }
        $ioStream->success('Execution completed.');

        return 0;
    }
}
