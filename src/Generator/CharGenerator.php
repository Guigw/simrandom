<?php

namespace Yrial\Simrandom\Generator;

class CharGenerator extends AbstractGenerator
{

    public function __construct($start, $end)
    {
        $this->possibilities = range($start, $end);
    }
}