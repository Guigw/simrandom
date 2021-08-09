<?php

namespace Yrial\Simrandom\Generator;

class ShapeLetterGenerator extends CharGenerator
{
    public function __construct(array $params)
    {
        parent::__construct($params['start'], $params['end']);
    }
}