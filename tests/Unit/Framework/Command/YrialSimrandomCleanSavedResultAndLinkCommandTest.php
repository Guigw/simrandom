<?php
namespace Yrial\Simrandom\Tests\Unit\Framework\Command;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Domain\Command\Cleaning\CleaningCommand;
use Yrial\Simrandom\Framework\Command\YrialSimrandomCleanSavedResultAndLinkCommand;

class YrialSimrandomCleanSavedResultAndLinkCommandTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws ReflectionException
     */
    public function test__construct()
    {
        $mockedCommandBusData = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBusData->execute(Argument::type(CleaningCommand::class))->shouldBeCalledOnce();

        $command = new YrialSimrandomCleanSavedResultAndLinkCommand($mockedCommandBusData->reveal());
        $ref = new ReflectionClass($command);
        $refMethod = $ref->getMethod('execute');
        $mockedInput = $this->prophesize(InputInterface::class);

        $this->assertEquals(Command::SUCCESS, $refMethod->invoke($command, $mockedInput->reveal(), new ConsoleOutput()));
    }
}
