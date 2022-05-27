<?php

namespace Yrial\Simrandom\Application\Handler\Result;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Command\Result\JsonResultCommand;

class JsonResultHandler implements HandlerInterface
{

    public function handle(JsonResultCommand $command, mixed $result): ResultResponseDto
    {
        return new ResultResponseDto(
            $command->savedResultCommand->generateResultCommand->type->value,
            $result->getResults(),
            $command->savedResultCommand->generateResultCommand->type->getGenerator()->getDependencies(),
            empty($result->getResults()) ? null : $result->getId()
        );
    }
}