<?php

namespace Yrial\Simrandom\Domain\ValueObject\Configuration;

use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;

class WeightedListConfiguration implements GeneratorConfiguration
{
    /** @var WeightedConfiguration[] $list */
    private array $list = [];

    /**
     * @param mixed $conf
     * @return void
     */
    public function configure(mixed $conf): void
    {
        foreach ($conf as $c) {
            $item = new WeightedConfiguration();
            $item->configure($c);
            $this->list[] = $item;
        }
    }

    /**
     * @return array
     */
    public function getPossibilities(): array
    {
        $response = [];
        foreach ($this->list as $color) {
            $response = array_merge($response, $color->getPossibilities());
        }
        return $response;
    }
}