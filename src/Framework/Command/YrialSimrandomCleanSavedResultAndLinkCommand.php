<?php

namespace Yrial\Simrandom\Framework\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;

#[AsCommand(name: 'yrial:simrandom:clean-saved-result-and-link', description: 'remove unused results')]
class YrialSimrandomCleanSavedResultAndLinkCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->commandBus->execute(new CleaningCommand());
        $io->info('unused results removed');
        $io->success('cleaning successful');

        return Command::SUCCESS;
    }
}
