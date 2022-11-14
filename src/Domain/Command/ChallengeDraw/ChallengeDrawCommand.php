<?php

namespace Yrial\Simrandom\Domain\Command\ChallengeDraw;

use DateTimeImmutable;
use DateTimeInterface;
use Yrial\Simrandom\Domain\Command\BaseCommand;

class ChallengeDrawCommand extends BaseCommand
{
    public readonly DateTimeInterface $dateTime;

    public function __construct(
        public readonly string $name,
        public readonly array  $results
    )
    {
        $this->dateTime = new DateTimeImmutable();
    }
}
