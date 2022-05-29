<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Command\Result;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Command\Result\GenerateResultCommand;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Domain\Generator\AbstractGenerator;
use Yrial\Simrandom\Domain\Generator\Generators;

class GenerateResultCommandTest extends TestCase
{

    public function test__constructGeneratorNotFound()
    {
        $this->expectException(RandomizerNotFoundException::class);
        new GenerateResultCommand('titouti');
    }

    public function testNext()
    {
        $command = new GenerateResultCommand('budget', 'pouet');
        $this->assertEmpty($command->next());
    }

    public function test__construct()
    {
        $command = new GenerateResultCommand('budget', 'pouet');
        $this->assertInstanceOf(Generators::class, $command->type);
        $this->assertInstanceOf(AbstractGenerator::class, $command->generator);
        $this->assertEquals(['pouet'], $command->params);
    }
}
