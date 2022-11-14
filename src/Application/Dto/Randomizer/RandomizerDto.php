<?php

namespace Yrial\Simrandom\Application\Dto\Randomizer;

use Yrial\Simrandom\Domain\ValueObject\Randomizer;

class RandomizerDto
{
    public readonly string $name;

    public function __construct(
        Randomizer $rando
    )
    {
        $this->name = $rando->name;
    }
}
