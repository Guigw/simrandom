<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Handler\Result;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Application\Handler\Result\SavedResultHandler;
use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;

class SavedResultHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testHandle()
    {
        $MockedRandomizerResultRepository = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $MockedRandomizerResultRepository->save(Argument::type(RandomizerResult::class))->shouldBeCalledOnce();
        $command = new SavedResultCommand('buildings');
        $handler = new SavedResultHandler($MockedRandomizerResultRepository->reveal());
        $this->assertInstanceOf(RandomizerResult::class, $handler->handle($command, ['riri', 'fifi', 'loulou']));
    }

    public function testHandleEmptyResult()
    {
        $MockedRandomizerResultRepository = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $MockedRandomizerResultRepository->save(Argument::type(RandomizerResult::class))->shouldNotBeCalled();
        $command = new SavedResultCommand('buildings');
        $handler = new SavedResultHandler($MockedRandomizerResultRepository->reveal());
        $this->assertInstanceOf(RandomizerResult::class, $handler->handle($command, []));
    }
}
