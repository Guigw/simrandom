<?php

namespace Yrial\Simrandom\Domain\Generator;

use Yrial\Simrandom\Domain\ValueObject\Configuration\MinMaxConfiguration;

abstract class IntGenerator extends AbstractGenerator
{
    public function __construct()
    {
        $this->configuration = new MinMaxConfiguration();
    }
}