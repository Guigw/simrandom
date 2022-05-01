<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Controller;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yrial\Simrandom\Application\Controller\ChallengeController;
use Yrial\Simrandom\Domain\Contract\UseCase\ChallengeServiceInterface;
use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

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

        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedChallengeService->get()->willReturn($serviceReturn);
        $controller = new ChallengeController($mockedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson(json_encode($params), $response->getContent());
    }

    public function testGetRandomizerList()
    {
        $serviceReturn = new DetailChallengeResponseDto(42, 'toto',
            new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou')));
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedChallengeService->find(Argument::is(42))->willReturn($serviceReturn);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(42);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function testGetRandomizerListNotFound()
    {
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedChallengeService->find(Argument::any())->willThrow(new ChallengeNotFoundException());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(43);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEmpty(json_decode($response->getContent()));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
