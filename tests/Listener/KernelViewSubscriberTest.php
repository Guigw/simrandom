<?php

namespace Yrial\Simrandom\Tests\Listener;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Yrial\Simrandom\Attribute\OutputMapper;
use Yrial\Simrandom\Listener\KernelViewSubscriber;
use Yrial\Simrandom\Logic\Transformer\MapperInterface;
use Yrial\Simrandom\Logic\Transformer\SavedChallengeResultsMapper;

class KernelViewSubscriberTest extends TestCase
{
    use ProphecyTrait;

    public function testOnKernelViewMapperEmpty()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->get(Argument::any())->shouldNotBeCalled();
        $sub = new KernelViewSubscriber($mockContainer->reveal());
        $sub->onKernelView($this->getViewEvent());
    }

    private function getViewEvent(): ViewEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        return new ViewEvent($mockKernel, $mockRequest, 42, '');
    }

    public function testOnKernelView()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockMapper = $this->prophesize(MapperInterface::class);
        $mockResult = $this->prophesize(JsonSerializable::class);
        $mockResult->jsonSerialize()->shouldBeCalledOnce()->willReturn(['pi']);
        $mockMapper->EntityToDTO(Argument::is('pipou'))->shouldBeCalledOnce()->willReturn($mockResult->reveal());
        $sub = new KernelViewSubscriber($mockContainer->reveal());
        $reflectionClass = new ReflectionClass(KernelViewSubscriber::class);
        $reflectionProperty = $reflectionClass->getProperty('mapper');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($sub, $mockMapper->reveal());
        $event = $this->getViewEvent();
        $event->setControllerResult('pipou');
        $sub->onKernelView($event);
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
        $this->assertEquals(json_encode(['pi']), $event->getResponse()->getContent());
    }

    public function testOnKernelViewArray()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockMapper = $this->prophesize(MapperInterface::class);
        $list = ['riri', 'fifi', 'loulou'];
        $response = array_map(function ($item) {
            $mockResult = $this->prophesize(JsonSerializable::class);
            $mockResult->jsonSerialize()->shouldBeCalledOnce()->willReturn($item);
            return $mockResult->reveal();
        }, $list);
        $mockMapper->EntityToDTO(Argument::is('riri'))->shouldBeCalledOnce()->willReturn($response[0]);
        $mockMapper->EntityToDTO(Argument::is('fifi'))->shouldBeCalledOnce()->willReturn($response[1]);
        $mockMapper->EntityToDTO(Argument::is('loulou'))->shouldBeCalledOnce()->willReturn($response[2]);
        $sub = new KernelViewSubscriber($mockContainer->reveal());
        $reflectionClass = new ReflectionClass(KernelViewSubscriber::class);
        $reflectionProperty = $reflectionClass->getProperty('mapper');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($sub, $mockMapper->reveal());
        $event = $this->getViewEvent();
        $event->setControllerResult($list);
        $sub->onKernelView($event);
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
        $this->assertEquals(json_encode($list), $event->getResponse()->getContent());
    }

    public function testOnKernelControllerEmpty()
    {
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->get(Argument::any())->shouldNotBeCalled();
        $sub = new KernelViewSubscriber($mockContainer->reveal());
        $event = $this->getControllerEvent(function () {
        });
        $sub->onKernelController($event);
    }

    private function getControllerEvent(callable $callable): ControllerEvent
    {
        $mockKernel = $this->prophesize(HttpKernelInterface::class)->reveal();
        $mockRequest = $this->prophesize(Request::class)->reveal();
        return new ControllerEvent($mockKernel, $callable, $mockRequest, 42);
    }

    public function testOnKernelController()
    {
        $mockMapper = $this->prophesize(MapperInterface::class)->reveal();
        $mockContainer = $this->prophesize(ContainerInterface::class);
        $mockContainer->get(Argument::is(SavedChallengeResultsMapper::class))->shouldBeCalled()->willReturn($mockMapper);
        $sub = new KernelViewSubscriber($mockContainer->reveal());
        $event = $this->getControllerEvent([$this->getAnonymousClass(), 'toto']);
        $sub->onKernelController($event);
        $ref = new ReflectionClass($sub);
        $props = $ref->getProperty('mapper');
        $props->setAccessible(true);
        $this->assertEquals($mockMapper, $props->getValue($sub));
    }

    private function getAnonymousClass(): object
    {
        return new class {
            #[OutputMapper(SavedChallengeResultsMapper::class)]
            public function toto()
            {

            }
        };
    }

    public function testGetSubscribedEvents()
    {
        $results = KernelViewSubscriber::getSubscribedEvents();
        $this->assertCount(2, $results);
        $this->assertArrayHasKey(KernelEvents::CONTROLLER, $results);
        $this->assertArrayHasKey(KernelEvents::VIEW, $results);
    }
}
