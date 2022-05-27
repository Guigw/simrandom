<?php

namespace Yrial\Simrandom\Application\CommandBus;

use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Inflector\CommandInflector;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

abstract class AbstractCommandBusInterface implements CommandBusInterface
{
    public function __construct(
        private readonly CommandInflector $commandInflector
    )
    {
    }

    public function execute(CommandInterface $command): mixed
    {
        return $this->getFinalResult($command);
    }

    private function getFinalResult(CommandInterface $command): mixed
    {
        if (!is_null($command->next())) {
            $result = $this->getFinalResult($command->next());
        }
        return $this->resolve($command, $this->commandInflector->inflate($command), $result ?? null);
    }

    abstract protected function resolve(CommandInterface $command, HandlerInterface $handler, mixed $prevResult = null);
}