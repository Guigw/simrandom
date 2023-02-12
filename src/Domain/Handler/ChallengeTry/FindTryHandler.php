<?php

namespace Yrial\Simrandom\Domain\Handler\ChallengeTry;

use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\TryRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Domain\Query\ChallengeTry\FindChallengeTryQuery;

class FindTryHandler implements HandlerInterface
{
    public function __construct(
        private readonly TryRepositoryInterface $savedChallengeRepository
    )
    {
    }

    public function handle(FindChallengeTryQuery $command): ChallengeTry
    {
        return $this->savedChallengeRepository->load($command->id);
    }
}
