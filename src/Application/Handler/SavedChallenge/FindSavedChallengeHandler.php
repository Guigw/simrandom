<?php

namespace Yrial\Simrandom\Application\Handler\SavedChallenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\SavedChallenge\FindSavedChallengeCommand;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class FindSavedChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface $savedChallengeRepository
    )
    {
    }

    public function handle(FindSavedChallengeCommand $command): SavedChallenge
    {
        return $this->savedChallengeRepository->load($command->id);
    }
}