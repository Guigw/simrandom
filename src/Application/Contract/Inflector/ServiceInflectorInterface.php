<?php

namespace Yrial\Simrandom\Application\Contract\Inflector;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Exception\HandlerImplementationException;

interface ServiceInflectorInterface
{
    /**
     * @param string $classname
     * @return HandlerInterface
     * @throws HandlerImplementationException
     */
    public function getHandler(string $classname): HandlerInterface;
}