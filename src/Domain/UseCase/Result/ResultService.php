<?php

namespace Yrial\Simrandom\Domain\UseCase\Result;

use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\ResultServiceInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Generator\Generators;

class ResultService implements ResultServiceInterface
{
    public function __construct(
        private readonly RandomizerConfigurationInterface $randomizerConfiguration,
        private readonly SavedResultServiceInterface $savedResultService,
    )
    {
    }

    /**
     * @param string $title
     * @param mixed $params
     * @return ResultResponseDto
     * @throws RandomizerConfigurationNotFoundException
     */
    public function generate(string $title, mixed ...$params): ResultResponseDto
    {
        $generatorType = Generators::tryFrom($title);
        $generator = $generatorType->getGenerator();
        $generator->configure($this->randomizerConfiguration->find($generatorType->value));
        $result = new ResultResponseDto($title, $generator->getRandom($params[0] ?? 1), $generator->getDependencies());
        $this->savedResultService->save($result);
        return $result;
    }


}