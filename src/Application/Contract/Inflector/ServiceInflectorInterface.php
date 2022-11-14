<?php

namespace Yrial\Simrandom\Application\Contract\Inflector;

use Yrial\Simrandom\Application\Exception\HandlerImplementationException;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;

interface ServiceInflectorInterface
{
    /**
     * @param string $classname
     * @return HandlerInterface
     * @throws HandlerImplementationException
     */
    public function getHandler(string $classname): HandlerInterface;
}