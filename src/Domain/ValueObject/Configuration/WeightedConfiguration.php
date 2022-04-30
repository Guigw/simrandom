<?php

namespace Yrial\Simrandom\Domain\ValueObject\Configuration;

use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;

class WeightedConfiguration implements GeneratorConfiguration
{
    private string $name;
    private int $weight;

    /**
     * @param mixed $conf
     * @return void
     */
    public function configure(mixed $conf): void
    {
        $this->name = $conf['name'];
        $this->weight = $conf['weight'];
    }

    /**
     * @return array
     */
    public function getPossibilities(): array
    {
        $response = [];
        for ($i = 0; $i < $this->weight; $i++) {
            $response[] = $this->name;
        }
        return $response;
    }
}