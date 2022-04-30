<?php

namespace Yrial\Simrandom\Domain\Contract\UseCase;

use Yrial\Simrandom\Domain\Dto\ResultResponseDto;

interface SavedResultServiceInterface extends CleanDataInterface
{
    public function save(ResultResponseDto $resultResponseDto): void;
}