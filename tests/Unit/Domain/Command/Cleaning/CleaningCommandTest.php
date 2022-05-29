<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Cleaning;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;

class CleaningCommandTest extends TestCase
{

    const DATEFORMAT = 'Y/m/d';

    public function test__construct()
    {
        $lastResultWithoutSavedChallengeDate = (new DateTimeImmutable())->sub(new DateInterval('P1D'));
        $lastSavedChallengeDate = (new DateTimeImmutable())->sub(new DateInterval('P3M'));
        $command = new CleaningCommand();
        $this->assertEquals($lastResultWithoutSavedChallengeDate->format(self::DATEFORMAT), $command->lastResultWithoutSavedChallengeDate->format(self::DATEFORMAT));
        $this->assertEquals($lastSavedChallengeDate->format(self::DATEFORMAT), $command->lastSavedChallengeDate->format(self::DATEFORMAT));
    }
}
