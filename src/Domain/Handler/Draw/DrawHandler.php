<?php

namespace Yrial\Simrandom\Domain\Handler\Draw;

use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Query\Draw\DrawQuery;

class DrawHandler implements HandlerInterface
{
    public function __construct(
        private readonly RandomizerConfigurationInterface $randomizerConfiguration
    )
    {
    }

    /**
     * @param DrawQuery $query
     * @return array
     * @throws RandomizerConfigurationNotFoundException
     */
    public function handle(DrawQuery $query): array
    {
        $generator = $query->generator;
        $generator->configure($this->randomizerConfiguration->find($query->type->value));
        return $generator->getRandom($this->getResponseNumber($query->params, !empty($generator->getDependencies())));
    }

    private function getResponseNumber(array $params, bool $hasDependencies): int
    {
        $num = 0;
        if (isset($params[0])) {
            $num = $params[0];
        } elseif (!$hasDependencies) {
            $num = 1;
        }
        return $num;
    }
}
