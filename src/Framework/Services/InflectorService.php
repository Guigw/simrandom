<?php

namespace Yrial\Simrandom\Framework\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Contract\Inflector\ServiceInflectorInterface;
use Yrial\Simrandom\Application\Exception\HandlerImplementationException;

class InflectorService implements ServiceInflectorInterface
{
    public function __construct(
        private readonly ContainerInterface $container)
    {
    }


    /**
     * @param string $classname
     * @return HandlerInterface
     * @throws HandlerImplementationException
     */
    public function getHandler(string $classname): HandlerInterface
    {
        $obj = $this->container->get($classname);
        if (!is_null($obj) && in_array(HandlerInterface::class, class_implements($obj))) {
            return $obj;
        }
        throw new HandlerImplementationException($classname);
    }
}