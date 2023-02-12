<?php

namespace Yrial\Simrandom\Domain\Query\ChallengeTry;

use Yrial\Simrandom\Domain\Command\BaseCommand;

class FindChallengeTryQuery extends BaseCommand
{
    public function __construct(
        public readonly string $id)
    {
    }
}
