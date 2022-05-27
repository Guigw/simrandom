<?php

namespace Yrial\Simrandom\Application\CommandBus;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

class ResultsCommandBus extends AbstractCommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @param HandlerInterface $handler
     * @param mixed|null $prevResult
     * @return mixed
     */
    protected function resolve(CommandInterface $command, HandlerInterface $handler, mixed $prevResult = null): mixed
    {
        return $handler->handle($command, $prevResult);
    }
}