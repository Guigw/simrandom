<?php

namespace Yrial\Simrandom\Domain\Command\Challenge\FindChallenge;

use Yrial\Simrandom\Domain\Command\BaseCommand;

class FindChallengeCommand extends BaseCommand
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}