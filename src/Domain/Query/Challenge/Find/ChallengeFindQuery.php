<?php

namespace Yrial\Simrandom\Domain\Query\Challenge\Find;

use Yrial\Simrandom\Domain\Command\BaseCommand;

class ChallengeFindQuery extends BaseCommand
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
