<?php

namespace Yrial\Simrandom\Domain\Handler\ChallengeTry;

use Yrial\Simrandom\Domain\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\TryRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;

class SaveTryHandler implements HandlerInterface
{
    public function __construct(
        private readonly TryRepositoryInterface $tryRepository,
    )
    {
    }

    public function handle(ChallengeDrawCommand $command): ChallengeTry
    {
        $challenge = new ChallengeTry($command->dateTime);
        $challenge->setName($command->name);
        $this->tryRepository->saveChallenge($challenge, $command->results);
        return $challenge;
    }
}
