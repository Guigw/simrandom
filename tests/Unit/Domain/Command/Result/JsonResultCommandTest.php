<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Result;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Result\JsonResultCommand;
use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;

class JsonResultCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new JsonResultCommand('budget', 'pouet');
        $this->assertInstanceOf(SavedResultCommand::class, $command->savedResultCommand);
    }

    public function testNext()
    {
        $command = new JsonResultCommand('budget', 'pouet');
        $this->assertInstanceOf(SavedResultCommand::class, $command->next());
    }
}
