<?php

namespace Yrial\Simrandom\Listener;

use JetBrains\PhpStorm\ArrayShape;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Yrial\Simrandom\Attribute\OutputMapper;
use Yrial\Simrandom\Logic\Transformer\MapperInterface;

class KernelViewSubscriber implements EventSubscriberInterface
{
    private ?MapperInterface $mapper;

    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([KernelEvents::CONTROLLER => "string", KernelEvents::VIEW => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::VIEW => 'onKernelView'
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        try {
            $reflectionClass = new ReflectionClass($controller[0]);
            $method = $reflectionClass->getMethod($controller[1]);
            if ($method && $attributes = $method->getAttributes(OutputMapper::class)) {
                $mapperInstance = $attributes[0]->newInstance();
                $this->mapper = $this->container->get($mapperInstance->mapper);
            }
        } catch (ReflectionException $e) {
            //Si jamais exception alors rien
        }
    }

    public function onKernelView(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        if (is_iterable($result)) {
            $dto = array_map(function ($res) {
                return $this?->mapper->EntityToDTO($res);
            }, $result);
        } else {
            $dto = $this?->mapper->EntityToDTO($result);
        }
        $response = new JsonResponse($dto);
        $event->setResponse($response);
    }
}