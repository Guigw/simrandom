<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use Yrial\Simrandom\Domain\Entity\Draw;

interface RandomizerResultRepositoryInterface
{
    public function save(Draw $result): Draw;

    public function removeUnusedResult(\DateTimeImmutable $lastDay): void;
}