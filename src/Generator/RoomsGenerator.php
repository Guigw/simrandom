<?php

namespace Yrial\Simrandom\Generator;

class RoomsGenerator extends IntGenerator
{
    public function __construct(array $params)
    {
        parent::__construct($params['min'], $params['max']);
    }
}