<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

interface CommandInterface
{
    public function next(): ?CommandInterface;
}
