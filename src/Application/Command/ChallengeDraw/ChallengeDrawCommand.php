<?php

namespace Yrial\Simrandom\Application\Command\ChallengeDraw;

use Yrial\Simrandom\Domain\Command\ChallengeDraw\ChallengeDrawCommand as DomainCommand;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

class ChallengeDrawCommand implements CommandInterface
{
    public readonly DomainCommand $challengeDrawCommand;

    public function __construct(
        string $name,
        array  $results
    )
    {
        $this->challengeDrawCommand = new DomainCommand($name, $results);
    }

    public function next(): ?CommandInterface
    {
        return $this->challengeDrawCommand;
    }
}
