<?php

namespace Yrial\Simrandom\Tests\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yrial\Simrandom\Controller\ChallengeController;
use Yrial\Simrandom\Entity\SavedChallenge;
use Yrial\Simrandom\Form\ResultListDTO;
use Yrial\Simrandom\Repository\SavedChallengeRepository;

class ChallengeControllerTest extends TestCase
{
    use ProphecyTrait;

    public function testFindSavedChallenge()
    {
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
        $challenge = new SavedChallenge();
        $challenge->setName('titouti');
        $this->assertEquals('titouti', $controller->findSavedChallenge($challenge)->getName());

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

        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockFormErrorIterator = $this->prophesize(FormErrorIterator::class);
        $mockedForm = $this->prophesize(FormInterface::class);
        $mockedForm->getErrors()->shouldBeCalledOnce()->willReturn($mockFormErrorIterator->reveal());
        $mockedForm->submit(Argument::any())->shouldBeCalledOnce()->willReturn($mockedForm);;
        $mockedForm->isSubmitted()->shouldBeCalledOnce()->willReturn(false);
        $mockedParams = $this->prophesize(FormFactoryInterface::class);
        $mockedParams->create(Argument::any(), Argument::any(), Argument::any())->willReturn($mockedForm->reveal());
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
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
        $ref->setAccessible(true);
        $ref->setValue($challenge, 42);
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockedChallengeRepository->saveChallenge(Argument::is('pipoupi'))->shouldBeCalledOnce()->willReturn($challenge);
        $mockedChallengeRepository->finishedChallenge(Argument::type(ArrayCollection::class), Argument::type(SavedChallenge::class))->shouldBeCalled();
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
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
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
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedParams = $this->prophesize(ParameterBagInterface::class);
        $mockedParams->get(Argument::is('generator.challenges'))->willReturn($params);
        $mockedContainer->has(Argument::is('parameter_bag'))->willReturn(true);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->index();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJson(json_encode($params), $response->getContent());
    }

    public function testGetRandomizerList()
    {
        $params = [
            [
                'id' => 42,
                'name' => 'toto',
                'randomizers' => ['riri', 'fifi', 'loulou']
            ]
        ];
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedParams = $this->prophesize(ParameterBagInterface::class);
        $mockedParams->get(Argument::is('generator.challenges'))->willReturn($params);
        $mockedContainer->has(Argument::is('parameter_bag'))->willReturn(true);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(42);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(json_encode($params[0]), $response->getContent());
    }

    public function testGetRandomizerListNotFound()
    {
        $params = [
            [
                'id' => 42,
                'name' => 'toto',
                'randomizers' => ['riri', 'fifi', 'loulou']
            ]
        ];
        $mockedChallengeRepository = $this->prophesize(SavedChallengeRepository::class);
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedParams = $this->prophesize(ParameterBagInterface::class);
        $mockedParams->get(Argument::is('generator.challenges'))->willReturn($params);
        $mockedContainer->has(Argument::is('parameter_bag'))->willReturn(true);
        $mockedContainer->has(Argument::is('serializer'))->willReturn(false);
        $mockedContainer->get(Argument::any())->willReturn($mockedParams->reveal());
        $controller = new ChallengeController($mockedChallengeRepository->reveal());
        $controller->setContainer($mockedContainer->reveal());
        $response = $controller->getRandomizerList(43);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEmpty(json_decode($response->getContent()));
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
