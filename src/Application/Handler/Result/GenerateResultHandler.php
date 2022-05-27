<?php

namespace Yrial\Simrandom\Application\Handler\Result;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\Result\GenerateResultCommand;
use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;

class GenerateResultHandler implements HandlerInterface
{
    public function __construct(
        private readonly RandomizerConfigurationInterface $randomizerConfiguration
    )
    {
    }

    /**
     * @param GenerateResultCommand $command
     * @return array
     * @throws RandomizerConfigurationNotFoundException
     */
    public function handle(GenerateResultCommand $command): array
    {
        $generator = $command->generator;
        $generator->configure($this->randomizerConfiguration->find($command->type->value));
        return $generator->getRandom($this->getResponseNumber($command->params, !empty($generator->getDependencies())));
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