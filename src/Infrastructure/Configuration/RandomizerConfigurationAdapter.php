<?php

namespace Yrial\Simrandom\Infrastructure\Configuration;

use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;

class RandomizerConfigurationAdapter implements RandomizerConfigurationInterface
{
    public function __construct(
        private readonly array $configurations
    )
    {
    }

    /**
     * @param string $title
     * @return array
     * @throws RandomizerConfigurationNotFoundException
     */
    public function find(string $title): array
    {
        if (!isset($this->configurations[$title])) {
            throw new RandomizerConfigurationNotFoundException();
        }

        return $this->configurations[$title];
    }


}