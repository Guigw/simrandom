<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\SavedChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\SavedChallenge\FindSavedChallengeCommand;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonFindSavedChallengeCommand;

class JsonFindSavedChallengeTest extends TestCase
{

    public function test__construct()
    {
        $command = new JsonFindSavedChallengeCommand(42);
        $this->assertInstanceOf(FindSavedChallengeCommand::class, $command->findSavedChallengeCommand);
    }

    public function testNext()
    {
        $command = new JsonFindSavedChallengeCommand(42);
        $this->assertInstanceOf(FindSavedChallengeCommand::class, $command->next());
    }
}
