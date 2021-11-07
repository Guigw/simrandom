<?php

namespace Yrial\Simrandom\Generator;

class ColorGenerator extends AbstractGenerator
{

    public function __construct(array $possibilities)
    {
        $this->possibilities = $possibilities;
    }
}