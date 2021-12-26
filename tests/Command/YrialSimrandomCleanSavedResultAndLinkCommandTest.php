<?php

namespace Yrial\Simrandom\Tests\Command;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Yrial\Simrandom\Command\YrialSimrandomCleanSavedResultAndLinkCommand;
use Yrial\Simrandom\Repository\RandomizerResultRepository;
use Yrial\Simrandom\Repository\SavedChallengeRepository;

class YrialSimrandomCleanSavedResultAndLinkCommandTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws ReflectionException
     */
    public function test__construct()
    {
        $mockedRandomRepository = $this->prophesize(RandomizerResultRepository::class);
        $mockedRandomRepository->removeUnusedResult()->shouldBeCalledOnce();
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockedChallengeRepository->removeOldLinks()->shouldBeCalledOnce();

        $command = new YrialSimrandomCleanSavedResultAndLinkCommand($mockedRandomRepository->reveal(), $mockedChallengeRepository->reveal());
        $ref = new ReflectionClass($command);
        $refMethod = $ref->getMethod('execute');
        $refMethod->setAccessible(true);
        $mockedInput = $this->prophesize(InputInterface::class);

        $this->assertEquals(Command::SUCCESS, $refMethod->invoke($command, $mockedInput->reveal(), new ConsoleOutput()));
    }
}
