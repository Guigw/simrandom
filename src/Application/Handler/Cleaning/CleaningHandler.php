<?php

namespace Yrial\Simrandom\Application\Handler\Cleaning;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;

class CleaningHandler implements HandlerInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface   $savedChallengeRepository,
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository
    )
    {
    }

    public function handle(CleaningCommand $command)
    {
        $this->randomizerResultRepository->removeUnusedResult($command->lastResultWithoutSavedChallengeDate);
        $this->savedChallengeRepository->removeOldChallenge($command->lastSavedChallengeDate);
    }
}