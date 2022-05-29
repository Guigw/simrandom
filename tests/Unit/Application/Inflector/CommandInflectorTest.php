<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Inflector;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Contract\Inflector\ServiceInflectorInterface;
use Yrial\Simrandom\Application\Inflector\CommandInflector;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\GetChallengeCommand;

class CommandInflectorTest extends TestCase
{
    use  ProphecyTrait;

    public function testInflate()
    {
        $findService = $this->prophesize(HandlerInterface::class);
        $service = $this->prophesize(ServiceInflectorInterface::class);
        $service->getHandler(Argument::type('string'))->shouldBeCalled()->willReturn($findService->reveal());

        $inflector = new CommandInflector($service->reveal());
        $this->assertInstanceOf(HandlerInterface::class, $inflector->inflate(new GetChallengeCommand()));

    }
}
