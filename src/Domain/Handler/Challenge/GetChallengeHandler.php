<?php

namespace Yrial\Simrandom\Domain\Handler\Challenge;

use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Query\Challenge\Get\ChallengeGetQuery;

class GetChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly ChallengeRepositoryInterface $challengeRepository
    )
    {

    }

    public function handle(ChallengeGetQuery $command): array
    {
        return $this->challengeRepository->get();
    }
}
