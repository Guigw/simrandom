<?php

namespace Yrial\Simrandom\Listener;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Yrial\Simrandom\Attribute\OutputMapper;
use Yrial\Simrandom\Logic\Transformer\MapperInterface;

class KernelViewSubscriber extends AbstractControllerSubscriber
{
    private ?MapperInterface $mapper = null;

    public function __construct(
        private readonly ContainerInterface $container
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
            KernelEvents::VIEW => 'onKernelView',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        try {
            if ($mapperInstance = $this->getInstance($event, OutputMapper::class)) {
                $this->mapper = $this->container->get($mapperInstance->mapper);
            }
        } catch (\ReflectionException) {
            $this->mapper = null;
        }

    }

    public function onKernelView(ViewEvent $event)
    {
        if ($this->mapper) {
            $result = $event->getControllerResult();
            if (is_iterable($result)) {
                $dto = array_map(function ($res) {
                    return $this->mapper->EntityToDTO($res);
                }, $result);
            } else {
                $dto = $this->mapper->EntityToDTO($result);
            }
            $response = new JsonResponse($dto);
            $event->setResponse($response);
        }
    }
}