<?php

namespace Yrial\Simrandom\Domain\Contract\Generator;

interface ChaosGenerator
{
    public function configure(mixed $conf): void;

    public function getRandom(int $number): array;

    /**
     * @return ?ChaosGenerator[]
     */
    public function getDependencies(): ?array;
}