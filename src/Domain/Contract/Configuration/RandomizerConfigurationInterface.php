<?php

namespace Yrial\Simrandom\Domain\Contract\Configuration;

use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;

interface RandomizerConfigurationInterface
{
    /**
     * @throws RandomizerConfigurationNotFoundException
     */
    public function find(string $title): array;
}