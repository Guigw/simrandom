<?php

namespace Yrial\Simrandom\Domain\Generator;

use Yrial\Simrandom\Domain\ValueObject\Configuration\DirectConfiguration;

class BuildingGenerator extends AbstractGenerator
{
    public function __construct()
    {
        $this->configuration = new DirectConfiguration();
    }
}