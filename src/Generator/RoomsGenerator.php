<?php

namespace Yrial\Simrandom\Generator;

use JetBrains\PhpStorm\Pure;

class RoomsGenerator extends IntGenerator
{
    #[Pure]
    public function __construct(array $params)
    {
        parent::__construct($params['min'], $params['max']);
    }
}