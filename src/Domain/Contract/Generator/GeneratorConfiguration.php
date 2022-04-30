<?php

namespace Yrial\Simrandom\Domain\Contract\Generator;

interface GeneratorConfiguration
{
    public function configure(mixed $conf): void;

    public function getPossibilities(): array;
}