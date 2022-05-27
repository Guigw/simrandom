<?php

namespace Yrial\Simrandom\Domain\Command\Challenge\GetChallenge;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

class JsonListChallengeCommand implements CommandInterface
{
    public readonly GetChallengeCommand $challengeCommand;

    public function __construct()
    {
        $this->challengeCommand = new GetChallengeCommand();
    }


    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->challengeCommand;
    }
}