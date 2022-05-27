<?php

namespace Yrial\Simrandom\Domain\Command\SavedChallenge;

use Yrial\Simrandom\Domain\Command\BaseCommand;

class FindSavedChallengeCommand extends BaseCommand
{

    public function __construct(
        public readonly string $id)
    {
    }
}