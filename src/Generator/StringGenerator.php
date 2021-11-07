<?php

namespace Yrial\Simrandom\Generator;

class StringGenerator extends AbstractGenerator
{
    public function __construct(array $params)
    {
        $this->possibilities = $params;
    }
}