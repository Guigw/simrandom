<?php

namespace Yrial\Simrandom\Generator;

class ColorGenerator extends AbstractGenerator
{

    function __construct(array $possibilities)
    {
        $this->possibilities = $possibilities;
    }
}