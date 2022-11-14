<?php

namespace Yrial\Simrandom\Domain\Command;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;

abstract class BaseCommand implements CommandInterface
{
    public function next(): ?CommandInterface
    {
        return null;
    }
}
