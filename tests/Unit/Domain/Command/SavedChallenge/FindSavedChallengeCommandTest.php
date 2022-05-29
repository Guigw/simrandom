<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\SavedChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\SavedChallenge\FindSavedChallengeCommand;

class FindSavedChallengeCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new FindSavedChallengeCommand(42);
        $this->assertEquals(42, $command->id);
    }

    public function testNext()
    {
        $command = new FindSavedChallengeCommand(42);
        $this->assertNull($command->next());
    }
}
