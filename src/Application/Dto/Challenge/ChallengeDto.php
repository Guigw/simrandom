<?php

namespace Yrial\Simrandom\Application\Dto\Challenge;

use Yrial\Simrandom\Application\Dto\Randomizer\RandomizerCollectionDto;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class ChallengeDto
{
    public readonly RandomizerCollectionDto $randomizers;

    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        Randomizers            $list
    )
    {
        $this->randomizers = new RandomizerCollectionDto($list);
    }
}
