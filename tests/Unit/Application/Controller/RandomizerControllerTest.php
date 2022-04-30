<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Controller;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Yrial\Simrandom\Application\Controller\RandomizerController;
use Yrial\Simrandom\Domain\Contract\UseCase\ResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;

class RandomizerControllerTest extends TestCase
{
    use ProphecyTrait;

    public function testBudget()
    {
        $responseDto = new ResultResponseDto('budget', [12345]);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('budget'))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->budget();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('budget', json_decode($response->getContent())->title);
        $this->assertEquals(12345, json_decode($response->getContent())->result);
    }

    public function testLetter()
    {
        $responseDto = new ResultResponseDto('letter', ['X']);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('letter'))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->letter();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('letter', json_decode($response->getContent())->title);
        $this->assertEquals('X', json_decode($response->getContent())->result);
    }

    public function testColors()
    {
        $responseDto = new ResultResponseDto('colors', [1, 2, 3, 4, 5]);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('colors'), Argument::is(42))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = new Request(['number' => 42]);
        $response = $controller->colors($request, 4);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('colors', json_decode($response->getContent())->title);
        $this->assertEquals('1, 2, 3, 4, 5', json_decode($response->getContent())->result);
    }

    public function testColorsDefaultNumber()
    {
        $responseDto = new ResultResponseDto('colors', [1, 2, 3, 4, 5]);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('colors'), Argument::is(4))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = new Request();
        $response = $controller->colors($request, 4);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('colors', json_decode($response->getContent())->title);
        $this->assertEquals('1, 2, 3, 4, 5', json_decode($response->getContent())->result);
    }

    public function testRooms()
    {
        $responseDto = new ResultResponseDto('rooms', [12]);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('rooms'))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->rooms();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('rooms', json_decode($response->getContent())->title);
        $this->assertEquals(12, json_decode($response->getContent())->result);
    }

    public function testBuildings()
    {
        $responseDto = new ResultResponseDto('buildings', ['Empire State Building']);
        $mockedService = $this->prophesize(ResultServiceInterface::class);
        $mockedService->generate(Argument::is('buildings'))->willReturn($responseDto);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new RandomizerController($mockedService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->buildings();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('buildings', json_decode($response->getContent())->title);
        $this->assertEquals('Empire State Building', json_decode($response->getContent())->result);
    }
}
