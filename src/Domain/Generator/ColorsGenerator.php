<?php

namespace Yrial\Simrandom\Domain\Generator;

use Yrial\Simrandom\Domain\Contract\Generator\ChaosGenerator;
use Yrial\Simrandom\Domain\ValueObject\Configuration\WeightedListConfiguration;

class ColorsGenerator extends AbstractGenerator
{
    public function __construct()
    {
        $this->configuration = new WeightedListConfiguration();
    }

    /**
     * @return ChaosGenerator[]
     */
    public function getDependencies(): array
    {
        return [Generators::Rooms->value];
    }
}