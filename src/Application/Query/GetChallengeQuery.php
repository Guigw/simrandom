<?php

namespace Yrial\Simrandom\Application\Query;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Query\Challenge\Get\ChallengeGetQuery;

class GetChallengeQuery implements \Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface
{
    public readonly ChallengeGetQuery $challengeQuery;

    public function __construct()
    {
        $this->challengeQuery = new ChallengeGetQuery();
    }


    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->challengeQuery;
    }
}
