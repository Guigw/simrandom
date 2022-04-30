<?php

namespace Yrial\Simrandom\Domain\UseCase\Result;

use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;

class SavedResultService implements SavedResultServiceInterface
{
    public function __construct(
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository)
    {

    }

    /**
     * @param ResultResponseDto $resultResponseDto
     * @return void
     */
    public function save(ResultResponseDto $resultResponseDto): void
    {
        $stringifierResults = ResultResponseDto::arrayParamsToString($resultResponseDto->results);
        if (!empty($stringifierResults)) {
            $randoResult = $this->randomizerResultRepository->save($resultResponseDto->title, $stringifierResults);
            $resultResponseDto->setId($randoResult->getId());
        }
    }

    /**
     * @return void
     */
    public function cleanResults(): void
    {
        $lastDay = (new \DateTimeImmutable())->sub(new \DateInterval('P1D'));
        $this->randomizerResultRepository->removeUnusedResult($lastDay);
    }


}