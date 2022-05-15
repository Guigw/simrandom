<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

use Yrial\Simrandom\Domain\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;

interface SavedChallengeServiceInterface
{
    /**
     * @param string $name
     * @param RandomizerResult[] $savedResults
     * @return SavedChallengeDto
     */
    public function save(string $name, array $savedResults): SavedChallengeDto;

    public function find(string $id): ?SavedChallengeDto;
}