<?php

namespace Yrial\Simrandom\Domain\Handler\ChallengeDraw;

use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Domain\Query\ChallengeDraw\FindChallengeDrawQuery;

class FindChallengeDrawHandler implements HandlerInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface $savedChallengeRepository
    )
    {
    }

    public function handle(FindChallengeDrawQuery $command): SavedChallenge
    {
        return $this->savedChallengeRepository->load($command->id);
    }
}
