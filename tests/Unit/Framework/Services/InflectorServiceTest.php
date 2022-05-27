<?php

namespace Yrial\Simrandom\Tests\Unit\Framework\Services;

use DateTime;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Exception\HandlerImplementationException;
use Yrial\Simrandom\Framework\Services\InflectorService;

class InflectorServiceTest extends TestCase
{

    use ProphecyTrait;

    public function testGetHandler()
    {
        $findService = $this->prophesize(HandlerInterface::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(Argument::is('titouti'))->shouldBeCalledOnce()->willReturn($findService->reveal());
        $service = new InflectorService($container->reveal());
        $this->assertInstanceOf(HandlerInterface::class, $service->getHandler('titouti'));
    }

    public function testGetHandlerNull()
    {
        $this->expectException(HandlerImplementationException::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(Argument::is('titouti'))->shouldBeCalledOnce()->willReturn(null);
        $service = new InflectorService($container->reveal());
        $service->getHandler('titouti');
    }

    public function testGetHandlerWrongInterface()
    {
        $this->expectException(HandlerImplementationException::class);
        $findService = new DateTime();
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(Argument::is('titouti'))->shouldBeCalledOnce()->willReturn($findService);
        $service = new InflectorService($container->reveal());
        $service->getHandler('titouti');
    }

}
