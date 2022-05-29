<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Challenge\FindChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\FindChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\JsonDetailChallengeCommand;

class JsonDetailChallengeCommandTest extends TestCase
{

    public function testNext()
    {
        $command = new JsonDetailChallengeCommand(42);
        $this->assertInstanceOf(FindChallengeCommand::class, $command->next());
    }

    public function test__construct()
    {
        $command = new JsonDetailChallengeCommand(42);
        $this->assertInstanceOf(FindChallengeCommand::class, $command->findChallengeCommand);
    }
}
