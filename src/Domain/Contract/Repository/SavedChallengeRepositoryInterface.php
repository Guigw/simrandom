<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

interface SavedChallengeRepositoryInterface
{
    public function removeOldChallenge(\DateTimeImmutable $lastDay): void;

    /**
     * @param SavedChallenge $savedChallenge
     * @param RandomizerResult[] $randomizerResults
     * @return SavedChallenge
     */
    public function saveChallenge(SavedChallenge $savedChallenge, array $randomizerResults): SavedChallenge;

    public function load(string $id): ?SavedChallenge;
}
