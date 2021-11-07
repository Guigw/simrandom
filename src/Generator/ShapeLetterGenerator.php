<?php

namespace Yrial\Simrandom\Generator;

use JetBrains\PhpStorm\Pure;

class ShapeLetterGenerator extends CharGenerator
{
    #[Pure]
    public function __construct(array $params)
    {
        parent::__construct($params['start'], $params['end']);
    }
}