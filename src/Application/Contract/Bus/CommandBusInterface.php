<?php

namespace Yrial\Simrandom\Application\Contract\Bus;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): mixed;
}