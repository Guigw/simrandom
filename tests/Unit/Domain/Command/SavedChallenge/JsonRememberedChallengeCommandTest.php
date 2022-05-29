<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\SavedChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonRememberedChallengeCommand;
use Yrial\Simrandom\Domain\Command\SavedChallenge\RememberChallengeCommand;

class JsonRememberedChallengeCommandTest extends TestCase
{

    public function testNext()
    {
        $command = new  JsonRememberedChallengeCommand(42, ['riri', 'fifi']);
        $this->assertInstanceOf(RememberChallengeCommand::class, $command->rememberChallengeCommand);
    }

    public function test__construct()
    {
        $command = new  JsonRememberedChallengeCommand(42, ['riri', 'fifi']);
        $this->assertInstanceOf(RememberChallengeCommand::class, $command->next());
    }
}
