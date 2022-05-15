<?php

namespace Yrial\Simrandom\Domain\UseCase\Cleaning;

use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\CleanDataInterface;

class CleanDataService implements CleanDataInterface
{

    public function __construct(
        private readonly SavedChallengeRepositoryInterface   $savedChallengeRepository,
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository
    )
    {
    }

    public function cleanResults(): void
    {
        $this->cleanSavedResult();
        $this->cleanChallenge();
    }

    /**
     * @return void
     */
    private function cleanSavedResult(): void
    {
        $lastDay = (new \DateTimeImmutable())->sub(new \DateInterval('P1D'));
        $this->randomizerResultRepository->removeUnusedResult($lastDay);
    }

    private function cleanChallenge(): void
    {
        $lastThreeMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $this->savedChallengeRepository->removeOldChallenge($lastThreeMonth);
    }
}