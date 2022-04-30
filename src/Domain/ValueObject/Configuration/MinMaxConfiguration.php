<?php

namespace Yrial\Simrandom\Domain\ValueObject\Configuration;

use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;

class MinMaxConfiguration implements GeneratorConfiguration
{
    private int $min;
    private int $max;

    /**
     * @return array
     */
    public function getPossibilities(): array
    {
        return range($this->min, $this->max);
    }

    /**
     * @param mixed $conf
     * @return void
     */
    public function configure(mixed $conf): void
    {
        $this->max = $conf['max'];
        $this->min = $conf['min'];
    }


}