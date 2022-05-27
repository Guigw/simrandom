<?php

namespace Yrial\Simrandom\Domain\Command\Challenge\FindChallenge;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

class JsonDetailChallengeCommand implements CommandInterface
{
    public readonly FindChallengeCommand $findChallengeCommand;

    public function __construct(int $id)
    {
        $this->findChallengeCommand = new FindChallengeCommand($id);
    }

    public function next(): ?CommandInterface
    {
        return $this->findChallengeCommand;
    }
}