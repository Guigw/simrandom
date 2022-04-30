<?php

namespace Yrial\Simrandom\Domain\ValueObject\Configuration;

use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;

class DirectConfiguration implements GeneratorConfiguration
{
    /** @var string[] $list */
    private array $list;

    /**
     * @param mixed $conf
     * @return void
     */
    public function configure(mixed $conf): void
    {
        $this->list = $conf;
    }

    /**
     * @return array
     */
    public function getPossibilities(): array
    {
        return $this->list;
    }

}