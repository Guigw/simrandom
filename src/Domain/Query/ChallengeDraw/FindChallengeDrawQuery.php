<?php

namespace Yrial\Simrandom\Domain\Query\ChallengeDraw;

use Yrial\Simrandom\Domain\Command\BaseCommand;

class FindChallengeDrawQuery extends BaseCommand
{
    public function __construct(
        public readonly string $id)
    {
    }
}
