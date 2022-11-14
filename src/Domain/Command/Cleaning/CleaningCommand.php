<?php

namespace Yrial\Simrandom\Domain\Command\Cleaning;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Yrial\Simrandom\Domain\Command\BaseCommand;

class CleaningCommand extends BaseCommand
{
    public readonly DateTimeInterface $lastResultWithoutSavedChallengeDate;

    public readonly DateTimeInterface $lastSavedChallengeDate;

    public function __construct()
    {
        $this->lastResultWithoutSavedChallengeDate = (new DateTimeImmutable())->sub(new DateInterval('P1D'));
        $this->lastSavedChallengeDate = (new DateTimeImmutable())->sub(new DateInterval('P3M'));
    }
}
