<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\FindChallengeCommand;
use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class FindChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly ChallengeRepositoryInterface $challengeRepository
    )
    {
    }

    /**
     * @param FindChallengeCommand $findChallengeCommand
     * @return Challenge
     * @throws ChallengeNotFoundException
     */
    public function handle(FindChallengeCommand $findChallengeCommand): Challenge
    {
        return $this->challengeRepository->find($findChallengeCommand->id);
    }
}