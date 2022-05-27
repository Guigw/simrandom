<?php

namespace Yrial\Simrandom\Domain\Command\SavedChallenge;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\JsonSavedChallengeCommandInterface;

class JsonFindSavedChallenge implements JsonSavedChallengeCommandInterface
{
    public readonly FindSavedChallengeCommand $findSavedChallengeCommand;

    public function __construct(string $id)
    {
        $this->findSavedChallengeCommand = new FindSavedChallengeCommand($id);
    }

    public function next(): ?CommandInterface
    {
        return $this->findSavedChallengeCommand;
    }
}