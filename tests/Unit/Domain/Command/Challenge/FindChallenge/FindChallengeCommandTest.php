<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Challenge\FindChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\FindChallengeCommand;

class FindChallengeCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new FindChallengeCommand(42);
        $this->assertEquals(42, $command->id);
    }

    public function testNext()
    {
        $command = new FindChallengeCommand(42);
        $this->assertNull($command->next());
    }
}
