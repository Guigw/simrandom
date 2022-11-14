<?php

namespace Yrial\Simrandom\Domain\Handler\Challenge;

use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\Query\Challenge\Find\ChallengeFindQuery;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class FindChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly ChallengeRepositoryInterface $challengeRepository
    )
    {
    }

    /**
     * @param ChallengeFindQuery $findChallengeQuery
     * @return Challenge
     * @throws ChallengeNotFoundException
     */
    public function handle(ChallengeFindQuery $findChallengeQuery): Challenge
    {
        return $this->challengeRepository->find($findChallengeQuery->id);
    }
}
