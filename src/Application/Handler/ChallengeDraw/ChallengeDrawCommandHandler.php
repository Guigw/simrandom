<?php

namespace Yrial\Simrandom\Application\Handler\ChallengeDraw;

use Yrial\Simrandom\Application\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Application\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class ChallengeDrawCommandHandler
{
    public function handle(ChallengeDrawCommand $command, SavedChallenge $savedChallenge): SavedChallengeDto
    {
        return new SavedChallengeDto($savedChallenge);
    }
}
