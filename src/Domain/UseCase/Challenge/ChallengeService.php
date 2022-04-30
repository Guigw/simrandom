<?php

namespace Yrial\Simrandom\Domain\UseCase\Challenge;

use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\ChallengeServiceInterface;
use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class ChallengeService implements ChallengeServiceInterface
{
    public function __construct(
        private readonly ChallengeRepositoryInterface $challengeRepository
    )
    {
    }

    /**
     * @return ListChallengeResponseDto[]
     */
    public function get(): array
    {
        return array_map(function (Challenge $challenge) {
            return new ListChallengeResponseDto($challenge->getId(), $challenge->getName(), count($challenge->getRandomizers()));
        }, $this->challengeRepository->get());
    }

    /**
     * @param int $id
     * @return DetailChallengeResponseDto
     * @throws ChallengeNotFoundException
     */
    public function find(int $id): DetailChallengeResponseDto
    {
        $challenge = $this->challengeRepository->find($id);
        return new DetailChallengeResponseDto($challenge->getId(), $challenge->getName(), $challenge->getRandomizers());
    }

}