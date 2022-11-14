<?php

namespace Yrial\Simrandom\Application\Query;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Query\Challenge\Find\ChallengeFindQuery;

class FindChallengeQuery implements CommandInterface
{
    public readonly ChallengeFindQuery $findChallengeQuery;

    public function __construct(int $id)
    {
        $this->findChallengeQuery = new ChallengeFindQuery($id);
    }

    public function next(): ?CommandInterface
    {
        return $this->findChallengeQuery;
    }
}
