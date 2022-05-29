<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Challenge\GetChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\GetChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\JsonListChallengeCommand;

class JsonListChallengeCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new JsonListChallengeCommand();
        $this->assertInstanceOf(GetChallengeCommand::class, $command->challengeCommand);
    }

    public function testNext()
    {
        $command = new JsonListChallengeCommand();
        $this->assertInstanceOf(GetChallengeCommand::class, $command->next());
    }
}
