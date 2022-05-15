<?php

namespace Yrial\Simrandom\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yrial\Simrandom\Domain\Contract\UseCase\CleanDataInterface;

class YrialSimrandomCleanSavedResultAndLinkCommand extends Command
{
    protected static $defaultName = 'yrial:simrandom:clean-saved-result-and-link';
    protected static $defaultDescription = 'remove unused results';

    public function __construct(
        private readonly CleanDataInterface $cleanDataService,)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->cleanDataService->cleanResults();
        $io->info('unused results removed');
        $io->success('cleaning successful');

        return Command::SUCCESS;
    }
}
