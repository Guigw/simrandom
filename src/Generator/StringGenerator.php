<?php

namespace Yrial\Simrandom\Generator;

class StringGenerator extends AbstractGenerator
{
    function __construct(array $possibilities)
    {
        $this->possibilities = $possibilities;
    }
}