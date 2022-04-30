<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;

interface ChallengeServiceInterface
{
    /**
     * @return ListChallengeResponseDto[]
     */
    public function get(): array;

    public function find(int $id): DetailChallengeResponseDto;
}