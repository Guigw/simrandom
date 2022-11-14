<?php

namespace Yrial\Simrandom\Application\Inflector;

use Yrial\Simrandom\Application\Contract\Inflector\ServiceInflectorInterface;
use Yrial\Simrandom\Application\Exception\HandlerImplementationException;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

class CommandInflector
{
    public function __construct(
        private readonly ServiceInflectorInterface $serviceInflector
    )
    {

    }

    /**
     * @param CommandInterface $command
     * @return HandlerInterface
     * @throws HandlerImplementationException
     *
     */
    public function inflate(CommandInterface $command): HandlerInterface
    {
        return $this->serviceInflector->getHandler(HandlerCommand::tryFrom(get_class($command))->getHandlerClass());
    }
}
