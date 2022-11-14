<?php

namespace Yrial\Simrandom\Domain\Generator;

use Yrial\Simrandom\Domain\Contract\Generator\ChaosGenerator;
use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;


abstract class AbstractGenerator implements ChaosGenerator
{
    protected ?array $possibilities;

    protected GeneratorConfiguration $configuration;

    public function getRandom(int $number = 1): array
    {
        $response = [];
        for ($i = 0; $i < $number; $i++) {
            $response[] = $this->possibilities[array_rand($this->possibilities)];
        }
        return $response;
    }

    public function configure(mixed $conf): void
    {
        $this->configuration?->configure($conf);
        $this->possibilities = $this->configuration?->getPossibilities();
    }

    /**
     * @return ?array
     */
    public function getDependencies(): ?array
    {
        return null;
    }
}
