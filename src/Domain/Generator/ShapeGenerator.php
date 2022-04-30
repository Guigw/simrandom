<?php

namespace Yrial\Simrandom\Domain\Generator;

use Yrial\Simrandom\Domain\ValueObject\Configuration\StartEndConfiguration;

class ShapeGenerator extends AbstractGenerator
{
    public function __construct()
    {
        $this->configuration = new StartEndConfiguration();
    }
}