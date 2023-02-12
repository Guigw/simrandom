<?php

namespace Yrial\Simrandom\Domain\Contract\Repository;

use DateTimeImmutable;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;
use Yrial\Simrandom\Domain\Entity\Draw;

interface TryRepositoryInterface
{
    public function removeOldChallenge(DateTimeImmutable $lastDay): void;

    /**
     * @param ChallengeTry $try
     * @param Draw[] $randomizerResults
     * @return ChallengeTry
     */
    public function saveChallenge(ChallengeTry $try, array $randomizerResults): ChallengeTry;

    public function load(string $id): ?ChallengeTry;
}
