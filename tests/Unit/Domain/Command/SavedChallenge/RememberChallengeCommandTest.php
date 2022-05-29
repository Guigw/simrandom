<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\SavedChallenge;

use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\SavedChallenge\RememberChallengeCommand;

class RememberChallengeCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new RememberChallengeCommand(42, ['riri', 'fifi']);
        $this->assertEquals(42, $command->name);
        $this->assertEquals(['riri', 'fifi'], $command->results);
    }

    public function test__constructDate()
    {
        $command = new RememberChallengeCommand(42, ['riri', 'fifi']);
        $this->assertInstanceOf(DateTimeInterface::class, $command->dateTime);
    }

    public function testNext()
    {
        $command = new RememberChallengeCommand(42, ['riri', 'fifi']);
        $this->assertNull($command->next());
    }

}
