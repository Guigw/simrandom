<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

interface ResultServiceInterface
{
    /**
     * @param string $title
     * @param mixed ...$params
     * @return ResultResponseDto
     * @throws RandomizerConfigurationNotFoundException
     * @throws RandomizerNotFoundException
     */
    public function generate(string $title, mixed ...$params): ResultResponseDto;
}