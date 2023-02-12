<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Handler\Cleaning;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Application\Handler\Cleaning\CleaningHandler;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\Repository\TryRepositoryInterface;

class CleaningHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testHandle()
    {
        $mockedSavedChallengeRepository = $this->prophesize(TryRepositoryInterface::class);
        $mockedRandomizerResultRepository = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedSavedChallengeRepository->removeOldChallenge(Argument::type(\DateTimeImmutable::class))->shouldBeCalledOnce();
        $mockedRandomizerResultRepository->removeUnusedResult(Argument::type(\DateTimeImmutable::class))->shouldBeCalledOnce();
        $handler = new CleaningHandler($mockedSavedChallengeRepository->reveal(), $mockedRandomizerResultRepository->reveal());
        $handler->handle(new CleaningCommand());

    }
}
