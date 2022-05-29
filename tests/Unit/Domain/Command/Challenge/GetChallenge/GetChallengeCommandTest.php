<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Challenge\GetChallenge;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\GetChallengeCommand;

class GetChallengeCommandTest extends TestCase
{
    public function testNext()
    {
        $command = new GetChallengeCommand();
        $this->assertNull($command->next());
    }
}
