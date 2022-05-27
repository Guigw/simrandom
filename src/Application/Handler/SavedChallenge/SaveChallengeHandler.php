<?php

namespace Yrial\Simrandom\Application\Handler\SavedChallenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\SavedChallenge\RememberChallengeCommand;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SaveChallengeHandler implements HandlerInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface $savedChallengeRepository
    )
    {
    }

    public function handle(RememberChallengeCommand $command): SavedChallenge
    {
        $challenge = new SavedChallenge($command->dateTime);
        $challenge->setName($command->name);
        $this->savedChallengeRepository->saveChallenge($challenge, $command->results);
        return $challenge;
    }
}