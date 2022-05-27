<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use Yrial\Simrandom\Domain\Entity\RandomizerResult;

interface RandomizerResultRepositoryInterface
{
    public function save(RandomizerResult $result): RandomizerResult;

    public function removeUnusedResult(\DateTimeImmutable $lastDay): void;
}