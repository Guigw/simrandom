<?php

namespace Yrial\Simrandom\Generator;

class IntGenerator extends AbstractGenerator
{

    function __construct(int $min, int $max)
    {
        $this->possibilities = range($min, $max);
    }
}