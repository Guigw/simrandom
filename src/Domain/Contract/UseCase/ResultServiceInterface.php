<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

use Yrial\Simrandom\Domain\Dto\ResultResponseDto;

interface ResultServiceInterface
{
    public function generate(string $title, mixed ...$params): ResultResponseDto;
}