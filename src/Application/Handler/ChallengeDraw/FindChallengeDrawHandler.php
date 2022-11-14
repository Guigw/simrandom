<?php

namespace Yrial\Simrandom\Application\Handler\ChallengeDraw;

use Yrial\Simrandom\Application\Dto\SavedChallengeDto;
use Yrial\Simrandom\Application\Query\FindChallengeDrawQuery;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class FindChallengeDrawHandler implements HandlerInterface
{
    public function handle(
        FindChallengeDrawQuery $query,
        SavedChallenge         $challengeDraw
    ): SavedChallengeDto
    {
        return new SavedChallengeDto($challengeDraw);
    }
}
