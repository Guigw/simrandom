<?php

namespace Yrial\Simrandom\Application\Handler\SavedChallenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Contract\UseCase\JsonSavedChallengeCommandInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class JsonSavingChallengeHandler implements HandlerInterface
{
    public function handle(JsonSavedChallengeCommandInterface $command, SavedChallenge $savedChallenge): SavedChallengeDto
    {
        return new SavedChallengeDto($savedChallenge);
    }
}