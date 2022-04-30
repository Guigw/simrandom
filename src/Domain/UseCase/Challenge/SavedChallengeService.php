<?php

namespace Yrial\Simrandom\Domain\UseCase\Challenge;

use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedChallengeServiceInterface;
use Yrial\Simrandom\Domain\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SavedChallengeService implements SavedChallengeServiceInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface $challengeRepository
    )
    {
    }

    public function cleanResults(): void
    {
        $lastThreeMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $this->challengeRepository->removeOldChallenge($lastThreeMonth);
    }

    public function save(string $name, array $savedResults): SavedChallengeDto
    {
        $challenge = new SavedChallenge();
        $challenge->setName($name);
        $this->challengeRepository->saveChallenge($challenge, $savedResults);
        return new SavedChallengeDto($challenge);

    }

    public function find(string $id): ?SavedChallengeDto
    {
        $challenge = $this->challengeRepository->load($id);
        return !is_null($challenge) ? new SavedChallengeDto($challenge) : null;
    }
}