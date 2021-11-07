<?php

namespace Yrial\Simrandom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yrial\Simrandom\Repository\RandomizerResultRepository;
use Yrial\Simrandom\Repository\SavedChallengeRepository;

class YrialSimrandomCleanSavedResultAndLinkCommand extends Command
{
    protected static $defaultName = 'yrial:simrandom:clean-saved-result-and-link';
    protected static $defaultDescription = 'remove unused results';

    private RandomizerResultRepository $randomizerResultRepository;
    private SavedChallengeRepository $savedChallengeRepository;

    public function __construct(RandomizerResultRepository $randomizerResultRepository, SavedChallengeRepository $savedChallengeRepository)
    {
        $this->randomizerResultRepository = $randomizerResultRepository;
        $this->savedChallengeRepository = $savedChallengeRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->savedChallengeRepository->removeOldLinks();
        $io->info('old links removed');
        $this->randomizerResultRepository->removeUnusedResult();
        $io->info('unused results removed');
        $io->success('cleaning successful');

        return Command::SUCCESS;
    }
}
