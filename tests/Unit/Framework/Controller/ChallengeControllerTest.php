<?php

namespace Yrial\Simrandom\Tests\Unit\Framework\Controller;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Application\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Application\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\JsonDetailChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\JsonListChallengeCommand;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;
use Yrial\Simrandom\Framework\Controller\ChallengeController;

class ChallengeControllerTest extends TestCase
{

    use ProphecyTrait;

    public function testIndex()
    {
        $params = [
            [
                'id' => 42,
                'name' => 'toto',
                'randomizers' => ['riri', 'fifi', 'loulou']
            ]
        ];
        $serviceReturn = [new ListChallengeResponseDto(42, 'toto', 3)];

        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedCommandBus->execute(Argument::type(JsonListChallengeCommand::class))->willReturn($serviceReturn);
        $controller = new ChallengeController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson(json_encode($params), $response->getContent());
    }

    public function testGetRandomizerList()
    {
        $serviceReturn = new DetailChallengeResponseDto(42, 'toto',
            new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou')));
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonDetailChallengeCommand::class))->willReturn($serviceReturn);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(42);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function testGetRandomizerListNotFound()
    {
        $mockedCommandBus = $this->prophesize(CommandBusInterface::class);
        $mockedCommandBus->execute(Argument::type(JsonDetailChallengeCommand::class))->willThrow(new ChallengeNotFoundException());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedCommandBus->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(43);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEmpty(json_decode($response->getContent()));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
