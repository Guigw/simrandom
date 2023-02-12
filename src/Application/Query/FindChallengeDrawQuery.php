<?php

namespace Yrial\Simrandom\Application\Query;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Query\ChallengeTry\FindChallengeTryQuery as DomainQuery;

class FindChallengeDrawQuery implements CommandInterface
{
    public readonly DomainQuery $challengeFindQuery;

    public function __construct(string $id)
    {
        $this->challengeFindQuery = new DomainQuery($id);
    }

    public function next(): ?CommandInterface
    {
        return $this->challengeFindQuery;
    }
}
