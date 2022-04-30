<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use ReflectionProperty;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yrial\Simrandom\Application\Controller\ChallengeController;
use Yrial\Simrandom\Domain\Contract\UseCase\ChallengeServiceInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedChallengeServiceInterface;
use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\Input\ResultListDTO;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class ChallengeControllerTest extends TestCase
{
    use ProphecyTrait;

    public function testFindSavedChallenge()
    {
        $challenge = (new SavedChallenge())->setName('titouti');
        $ref = new ReflectionProperty($challenge, 'id');
        $ref->setValue($challenge, 42);
        $savedReturn = new SavedChallengeDto($challenge);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedSavedChallengeService->find(Argument::is('titouti'))->willReturn($savedReturn);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->findSavedChallenge('titouti');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertStringContainsString('titouti', $response);
    }

    public function testFindSavedChallengeNotFound()
    {
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedSavedChallengeService->find(Argument::is('titouti'))->willReturn(null);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->findSavedChallenge('titouti');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEmpty(json_decode($response->getContent()));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testSaveChallengeFormInvalid()
    {
        $requestBody = [
            'name' => 'pipoupi',
            'resultList' => [
                'id' => 'khijhkhmhik',
                'result' => 'lokiju'
            ]
        ];

        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockFormErrorIterator = $this->prophesize(FormErrorIterator::class);
        $mockedForm = $this->prophesize(FormInterface::class);
        $mockedForm->getErrors()->shouldBeCalledOnce()->willReturn($mockFormErrorIterator->reveal());
        $mockedForm->submit(Argument::any())->shouldBeCalledOnce()->willReturn($mockedForm);;
        $mockedForm->isSubmitted()->shouldBeCalledOnce()->willReturn(false);
        $mockedParams = $this->prophesize(FormFactoryInterface::class);
        $mockedParams->create(Argument::any(), Argument::any(), Argument::any())->willReturn($mockedForm->reveal());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = $this->prophesize(Request::class);
        $request->getContent()->shouldBeCalledOnce()->willReturn(json_encode($requestBody));
        $response = $controller->saveChallenge($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function testSaveChallenge()
    {
        $requestBody = [
            'name' => 'pipoupi',
            'resultList' => [
                'id' => 'khijhkhmhik',
                'result' => 'lokiju'
            ]
        ];
        $resultList = new ArrayCollection([
            'id' => 'khijhkhmhik',
            'result' => 'lokiju'
        ]);
        $dto = new ResultListDTO();
        $dto->setName('pipoupi');
        $dto->setResultList($resultList);

        $challenge = new SavedChallenge();
        $challenge->setName('lol');

        $ref = new ReflectionProperty($challenge, 'id');
        $ref->setValue($challenge, 42);
        $returnDto = new SavedChallengeDto($challenge);
        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedSavedChallengeService->save(Argument::is('pipoupi'), Argument::type('array'))->shouldBeCalledOnce()->willReturn($returnDto);
        $mockedForm = $this->prophesize(FormInterface::class);
        $mockedForm->getErrors()->shouldNotBeCalled();
        $mockedForm->submit(Argument::any())->shouldBeCalledOnce()->willReturn($mockedForm);
        $mockedForm->isSubmitted()->shouldBeCalledOnce()->willReturn(true);
        $mockedForm->isValid()->shouldBeCalledOnce()->willReturn(true);
        $mockedForm->getData()->shouldBeCalledOnce()->willReturn($dto);
        $mockedParams = $this->prophesize(FormFactoryInterface::class);
        $mockedParams->create(Argument::any(), Argument::any(), Argument::any())->willReturn($mockedForm->reveal());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $request = $this->prophesize(Request::class);
        $request->getContent()->shouldBeCalledOnce()->willReturn(json_encode($requestBody));
        $response = $controller->saveChallenge($request->reveal());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals(42, json_decode($response->getContent())->id);
    }

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

        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedChallengeService->get()->willReturn($serviceReturn);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson(json_encode($params), $response->getContent());
    }

    public function testGetRandomizerList()
    {
        $serviceReturn = new DetailChallengeResponseDto(42, 'toto',
            new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou')));
        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedChallengeService->find(Argument::is(42))->willReturn($serviceReturn);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(42);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function testGetRandomizerListNotFound()
    {
        $mockedSavedChallengeService = $this->prophesize(SavedChallengeServiceInterface::class);
        $mockedChallengeService = $this->prophesize(ChallengeServiceInterface::class);
        $mockedChallengeService->find(Argument::any())->willThrow(new ChallengeNotFoundException());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $controller = new ChallengeController($mockedChallengeService->reveal(), $mockedSavedChallengeService->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(43);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEmpty(json_decode($response->getContent()));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
