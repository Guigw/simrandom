<?php

namespace Yrial\Simrandom\Listener;

use JetBrains\PhpStorm\ArrayShape;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Yrial\Simrandom\Attribute\Configuration;
use Yrial\Simrandom\DTO\Result;
use Yrial\Simrandom\Exception\MissingConfigurationException;
use Yrial\Simrandom\Repository\RandomizerResultRepository;

class RandomizerResultSubscriber extends AbstractControllerSubscriber
{
    private ?string $key;
    private ?string $required;

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly RandomizerResultRepository $repository
    )
    {
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([KernelEvents::CONTROLLER => "string", KernelEvents::VIEW => "string", KernelEvents::EXCEPTION => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::VIEW => 'onKernelView',
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * @throws MissingConfigurationException
     * @throws ReflectionException
     */
    public function onKernelController(ControllerEvent $event)
    {
        if ($confInstance = $this->getInstance($event, Configuration::class)) {
            if (!in_array($confInstance->configuration, $this->container->getParameter('generator.randomizers.list'))) {
                throw new MissingConfigurationException($confInstance->configuration);
            }
            $this->key = $confInstance->configuration;
            $this->required ??= $confInstance->required;
        }
    }

    public function onKernelView(ViewEvent $event)
    {
        $event->setResponse(new JsonResponse(
            $this->formatItem($this->key, $event->getControllerResult())
                ->setRequired($this->required)
        ));
    }

    private function formatItem(string $key, $value): Result
    {
        $form = new Result();
        if ($value) {
            $entity = $this->repository->createResult($key, $value);
            $form->setId($entity->getId());
        }
        $form->setTitle($key)
            ->setResult($value);
        return $form;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if (is_a($exception, MissingConfigurationException::class)) {
            $event->setResponse(new JsonResponse([], Response::HTTP_NOT_FOUND));
        }
    }
}