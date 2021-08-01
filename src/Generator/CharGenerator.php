<?php

namespace Yrial\Simrandom\Generator;

class CharGenerator extends AbstractGenerator
{

    function __construct()
    {
        $this->possibilities = range("A", "Z");
    }
}