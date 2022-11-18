<?php

namespace Yrial\Simrandom\Domain\Handler\ChallengeDraw;

use Yrial\Simrandom\Domain\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SaveChallengeDrawHandler  implements HandlerInterface
{
    public function __construct(
        private readonly SavedChallengeRepositoryInterface $savedChallengeRepository,
    )
    {
    }

    public function handle(ChallengeDrawCommand $command): SavedChallenge
    {
        $challenge = new SavedChallenge($command->dateTime);
        $challenge->setName($command->name);
        $this->savedChallengeRepository->saveChallenge($challenge, $command->results);
        return $challenge;
    }
}
