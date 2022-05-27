<?php

namespace Yrial\Simrandom\Application\Handler\Result;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Exception\EmptyResultException;

class SavedResultHandler implements HandlerInterface
{
    public function __construct(
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository
    )
    {
    }

    /**
     * @param SavedResultCommand $command
     * @param mixed $result
     * @return RandomizerResult
     */
    public function handle(SavedResultCommand $command, mixed $result): RandomizerResult
    {
        $randomizerResult = new RandomizerResult($command->rollingDate);
        try {
            $randomizerResult->setName($command->generateResultCommand->type->value)
                ->pushResults($result);
            $this->randomizerResultRepository->save($randomizerResult);
        } catch (EmptyResultException) {
            $randomizerResult->setName($command->generateResultCommand->type->value);
        }
        return $randomizerResult;
    }
}