<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\GetChallengeCommand;
use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;

class GetChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly ChallengeRepositoryInterface $challengeRepository
    )
    {
    }

    /**
     * @param GetChallengeCommand $command
     * @return array
     */
    public function handle(GetChallengeCommand $command): array
    {
        return $this->challengeRepository->get();
    }
}