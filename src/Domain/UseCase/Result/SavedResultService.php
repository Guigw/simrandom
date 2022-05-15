<?php

namespace Yrial\Simrandom\Domain\UseCase\Result;

use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class SavedResultService implements SavedResultServiceInterface
{
    public function __construct(
        private readonly ResultService                       $resultService,
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository)
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
        $resultResponseDto = $this->resultService->generate($title, ...$params);
        $stringifierResults = ResultResponseDto::arrayParamsToString($resultResponseDto->results);
        if (!empty($stringifierResults)) {
            $randoResult = $this->randomizerResultRepository->save($resultResponseDto->title, $stringifierResults);
            $resultResponseDto->setId($randoResult->getId());
        }
        return $resultResponseDto;
    }
}