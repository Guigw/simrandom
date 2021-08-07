<?php

namespace Yrial\Simrandom\Generator;

class ColorsGenerator implements Randomizer
{
    private array $colorGenerators = [];

    function __construct(int $number, array $possibilities)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->colorGenerators[] = new StringGenerator($possibilities);
        }
    }

    public function getRandom()
    {
        return array_map(function(StringGenerator $colorGenerator) {
            return $colorGenerator->getRandom();
        }, $this->colorGenerators);
    }
}