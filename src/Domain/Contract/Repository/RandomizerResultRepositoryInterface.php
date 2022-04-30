<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use Yrial\Simrandom\Domain\Entity\RandomizerResult;

interface RandomizerResultRepositoryInterface
{
    public function save(string $key, string $value): RandomizerResult;

    public function removeUnusedResult(\DateTimeImmutable $lastDay): void;
}