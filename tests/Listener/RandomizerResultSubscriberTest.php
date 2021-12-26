<?php

namespace Yrial\Simrandom\Tests\Listener;

use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Yrial\Simrandom\Attribute\Configuration;
use Yrial\Simrandom\Entity\RandomizerResult;
use Yrial\Simrandom\Exception\MissingConfigurationException;
use Yrial\Simrandom\Listener\RandomizerResultSubscriber;
use Yrial\Simrandom\Repository\RandomizerResultRepository;

class RandomizerResultSubscriberTest extends TestCase
{
    use ProphecyTrait;

    public function testGetSubscribedEvents()
    {
        $events = RandomizerResultSubscriber::getSubscribedEvents();
        $this->assertCount(3, $events);
        $this->assertArrayHasKey(KernelEvents::CONTROLLER, $events);
        $this->assertArrayHasKey(KernelEvents::VIEW, $events);
        $this->assertArrayHasKey(KernelEvents::EXCEPTION, $events);
    }

    public function testOnKernelException()
    {
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $sub = new RandomizerResultSubscriber($mockedContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getExceptionEvent();
        $sub->onKernelException($event);
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $event->getResponse()->getStatusCode());
    }

    public function testOnKernelExceptionBadException()
    {
        $mockedContainer = $this->prophesize(ContainerInterface::class);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $sub = new RandomizerResultSubscriber($mockedContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getExceptionBadEvent();
        $sub->onKernelException($event);
        $this->assertEmpty($event->getResponse());
    }

    public function testOnKernelControllerMissingConf()
    {
        $this->expectException(MissingConfigurationException::class);
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->getParameter(Argument::is('generator.randomizers.list'))->shouldBeCalled()->willReturn([]);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $sub = new RandomizerResultSubscriber($mockContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getControllerEvent([$this->getAnonymousClass(), 'toto']);
        $sub->onKernelController($event);
    }

    public function testOnKernelController()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->getParameter(Argument::is('generator.randomizers.list'))->shouldBeCalled()->willReturn(['titi']);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $sub = new RandomizerResultSubscriber($mockContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getControllerEvent([$this->getAnonymousClass(), 'toto']);
        $sub->onKernelController($event);
        $ref = new ReflectionClass($sub);
        $propsKey = $ref->getProperty('key');
        $propsKey->setAccessible(true);
        $this->assertEquals('titi', $propsKey->getValue($sub));
        $propsRequired = $ref->getProperty('required');
        $propsRequired->setAccessible(true);
        $this->assertEquals('tata', $propsRequired->getValue($sub));
    }

    /**
     * @throws MissingConfigurationException
     */
    public function testOnKernelControllerEmpty()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->get(Argument::any())->shouldNotBeCalled();
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $sub = new RandomizerResultSubscriber($mockContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getControllerEvent(function () {
        });
        $sub->onKernelController($event);
    }

    public function testOnKernelView()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $mockEntity = $this->prophesize(RandomizerResult::class);
        $mockEntity->getId()->shouldBeCalledOnce()->willReturn(42);
        $mockedRepo->createResult(Argument::is('53'), Argument::is('formula1'))->shouldBeCalledOnce()->willReturn($mockEntity->reveal());
        $sub = new RandomizerResultSubscriber($mockContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getViewEvent('formula1');
        $reflectionClass = new ReflectionClass($sub);
        $reflectionProperty = $reflectionClass->getProperty('key');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($sub, 53);
        $reflectionProperty2 = $reflectionClass->getProperty('required');
        $reflectionProperty2->setAccessible(true);
        $reflectionProperty2->setValue($sub, 'required');
        $sub->onKernelView($event);
        $response = $event->getResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $decodeResponse = json_decode($response->getContent());
        $this->assertEquals(42, $decodeResponse->id);
        $this->assertEquals('53', $decodeResponse->title);
        $this->assertEquals('formula1', $decodeResponse->result);
        $this->assertEquals('required', $decodeResponse->required);
    }

    public function testOnKernelViewEmptyValue()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockedRepo = $this->prophesize(RandomizerResultRepository::class);
        $mockedRepo->createResult(Argument::any(), Argument::any())->shouldNotBeCalled();
        $sub = new RandomizerResultSubscriber($mockContainer->reveal(), $mockedRepo->reveal());
        $event = $this->getViewEvent('');
        $reflectionClass = new ReflectionClass($sub);
        $reflectionProperty = $reflectionClass->getProperty('key');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($sub, 53);
        $reflectionProperty2 = $reflectionClass->getProperty('required');
        $reflectionProperty2->setAccessible(true);
        $reflectionProperty2->setValue($sub, 'required');
        $sub->onKernelView($event);
        $response = $event->getResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $decodeResponse = json_decode($response->getContent());
        $this->assertEquals('53', $decodeResponse->title);
        $this->assertEquals('', $decodeResponse->result);
        $this->assertEquals('required', $decodeResponse->required);
    }

    private function getExceptionEvent(): ExceptionEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        $exception = new MissingConfigurationException("toto");
        return new ExceptionEvent($mockKernel, $mockRequest, 42, $exception);
    }

    private function getExceptionBadEvent(): ExceptionEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        $exception = new Exception("toto");
        return new ExceptionEvent($mockKernel, $mockRequest, 42, $exception);
    }

    private function getControllerEvent(callable $callable): ControllerEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        return new ControllerEvent($mockKernel, $callable, $mockRequest, 42);
    }

    private function getAnonymousClass(): object
    {
        return new class {
            #[Configuration('titi', 'tata')]
            public function toto()
            {

            }
        };
    }

    private function getViewEvent($result): ViewEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        return new ViewEvent($mockKernel, $mockRequest, 42, $result);
    }
}
