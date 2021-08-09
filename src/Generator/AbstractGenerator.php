<?php

namespace Yrial\Simrandom\Generator;

abstract class AbstractGenerator implements Randomizer
{
    protected $possibilities;

    public function getRandom()
    {
        return $this->possibilities[array_rand($this->possibilities)];
    }
}