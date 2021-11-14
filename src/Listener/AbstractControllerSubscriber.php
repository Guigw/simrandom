<?php

namespace Yrial\Simrandom\Listener;

use ReflectionClass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

abstract class AbstractControllerSubscriber implements EventSubscriberInterface
{
    protected function getInstance(ControllerEvent $event, string $class): ?object
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $reflectionClass = new ReflectionClass($controller[0]);
            $method = $reflectionClass->getMethod($controller[1]);
            //Vérification de la conf
            $attributes = $method?->getAttributes($class);
            if (is_iterable($attributes)) {
                return $attributes[0]->newInstance();
            }
        }
        return null;
    }
}