<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

interface CleanDataInterface
{
    public function cleanResults(): void;
}