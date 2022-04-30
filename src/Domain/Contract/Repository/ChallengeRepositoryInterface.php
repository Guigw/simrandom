<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

interface ChallengeRepositoryInterface
{
    public function get(): array;

    /**
     * @param int $id
     * @return Challenge
     * @throws ChallengeNotFoundException
     */
    public function find(int $id): Challenge;
}