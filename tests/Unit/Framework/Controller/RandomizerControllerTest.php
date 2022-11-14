<?php

namespace Yrial\Simrandom\Tests\Unit\Framework\Controller;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Application\Dto\Draw\DrawDto;
use Yrial\Simrandom\Domain\Command\Result\JsonResultCommand;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Framework\Controller\RandomizerController;

class RandomizerControllerTest extends TestCase
{
    use ProphecyTrait;

    public function testBudget()
    {
        $responseDto = new DrawDto('budget', [12345]);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'budget');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('budget', json_decode($response->getContent())->title);
        $this->assertEquals(12345, json_decode($response->getContent())->result);
    }

    public function testLetter()
    {
        $responseDto = new DrawDto('letter', ['X']);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'letter');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('letter', json_decode($response->getContent())->title);
        $this->assertEquals('X', json_decode($response->getContent())->result);
    }

    public function testColors()
    {
        $responseDto = new DrawDto('colors', [1, 2, 3, 4, 5]);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = new Request(['number' => 42]);
        $response = $controller->index($request, 'colors');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('colors', json_decode($response->getContent())->title);
        $this->assertEquals('1, 2, 3, 4, 5', json_decode($response->getContent())->result);
    }

    public function testColorsDefaultNumber()
    {
        $responseDto = new DrawDto('colors', []);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = new Request();
        $response = $controller->index($request, 'colors');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('colors', json_decode($response->getContent())->title);
        $this->assertEmpty(json_decode($response->getContent())->result);
    }

    public function testRooms()
    {
        $responseDto = new DrawDto('rooms', [12]);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'rooms');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('rooms', json_decode($response->getContent())->title);
        $this->assertEquals(12, json_decode($response->getContent())->result);
    }

    public function testBuildings()
    {
        $responseDto = new DrawDto('buildings', ['Empire State Building']);
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'buildings');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('buildings', json_decode($response->getContent())->title);
        $this->assertEquals('Empire State Building', json_decode($response->getContent())->result);
    }

    public function testRandomizerUnknown()
    {
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willThrow(new RandomizerNotFoundException());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'titouti');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testRandomizerMisconfiguration()
    {
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonResultCommand::class))->willThrow(new RandomizerConfigurationNotFoundException());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index(new Request(), 'titouti');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
