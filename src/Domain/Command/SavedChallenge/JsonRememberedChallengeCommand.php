<?php

namespace Yrial\Simrandom\Domain\Command\SavedChallenge;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\JsonSavedChallengeCommandInterface;

class JsonRememberedChallengeCommand implements JsonSavedChallengeCommandInterface
{
    public readonly RememberChallengeCommand $rememberChallengeCommand;

    public function __construct(
        string $name,
        array  $results
    )
    {
        $this->rememberChallengeCommand = new RememberChallengeCommand($name, $results);
    }

    public function next(): ?CommandInterface
    {
        return $this->rememberChallengeCommand;
    }
}