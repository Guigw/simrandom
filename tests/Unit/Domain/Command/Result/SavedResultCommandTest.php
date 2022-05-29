<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Result;

use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Result\GenerateResultCommand;
use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;

class SavedResultCommandTest extends TestCase
{

    public function test__construct()
    {
        $command = new SavedResultCommand('budget', 'pouet');
        $this->assertInstanceOf(GenerateResultCommand::class, $command->generateResultCommand);
        $this->assertInstanceOf(DateTimeInterface::class, $command->rollingDate);
    }

    public function testNext()
    {
        $command = new SavedResultCommand('budget', 'pouet');
        $this->assertInstanceOf(GenerateResultCommand::class, $command->next());
    }
}
