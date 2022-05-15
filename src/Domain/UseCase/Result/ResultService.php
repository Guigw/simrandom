<?php

namespace Yrial\Simrandom\Domain\UseCase\Result;

use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\ResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Domain\Generator\Generators;

class ResultService implements ResultServiceInterface
{
    public function __construct(
        private readonly RandomizerConfigurationInterface $randomizerConfiguration,
    )
    {
    }

    /**
     * @param string $title
     * @param mixed $params
     * @return ResultResponseDto
     * @throws RandomizerConfigurationNotFoundException
     * @throws RandomizerNotFoundException
     */
    public function generate(string $title, mixed ...$params): ResultResponseDto
    {
        $generatorType = Generators::tryFrom($title);
        if (is_null($generatorType)) {
            throw new RandomizerNotFoundException();
        }
        $generator = $generatorType->getGenerator();
        $generator->configure($this->randomizerConfiguration->find($generatorType->value));
        return new ResultResponseDto($title, $generator->getRandom($this->getResponseNumber($params, !empty($generator->getDependencies()))), $generator->getDependencies());
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