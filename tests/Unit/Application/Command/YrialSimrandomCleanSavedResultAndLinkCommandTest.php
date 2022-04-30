<?php
namespace Yrial\Simrandom\Tests\Unit\Application\Command;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Yrial\Simrandom\Application\Command\YrialSimrandomCleanSavedResultAndLinkCommand;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedChallengeServiceInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;

class YrialSimrandomCleanSavedResultAndLinkCommandTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws ReflectionException
     */
    public function test__construct()
    {
        $mockedRandomRepository = $this->prophesize(SavedResultServiceInterface::class);
        $mockedRandomRepository->cleanResults()->shouldBeCalledOnce();
        $mockedChallengeRepository = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedChallengeRepository->cleanResults()->shouldBeCalledOnce();

        $command = new YrialSimrandomCleanSavedResultAndLinkCommand($mockedRandomRepository->reveal(), $mockedChallengeRepository->reveal());
        $ref = new ReflectionClass($command);
        $refMethod = $ref->getMethod('execute');
        $mockedInput = $this->prophesize(InputInterface::class);

        $this->assertEquals(Command::SUCCESS, $refMethod->invoke($command, $mockedInput->reveal(), new ConsoleOutput()));
    }
}
