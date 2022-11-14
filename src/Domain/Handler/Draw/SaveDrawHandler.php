<?php

namespace Yrial\Simrandom\Domain\Handler\Draw;

use Yrial\Simrandom\Domain\Command\Result\SavedResultCommand;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Exception\EmptyResultException;
use Yrial\Simrandom\Domain\Query\Draw\SaveDrawQuery;

class SaveDrawHandler implements HandlerInterface
{
    public function __construct(
        private readonly RandomizerResultRepositoryInterface $randomizerResultRepository
    )
    {
    }

    /**
     * @param SaveDrawQuery $command
     * @param mixed $result
     * @return RandomizerResult
     */
    public function handle(SaveDrawQuery $command, mixed $result): RandomizerResult
    {
        $randomizerResult = new RandomizerResult($command->rollingDate);
        try {
            $randomizerResult->setName($command->drawQuery->type->value)
                ->pushResults($result);
            $this->randomizerResultRepository->save($randomizerResult);
        } catch (EmptyResultException) {
            $randomizerResult->setName($command->drawQuery->type->value);
        }
        return $randomizerResult;
    }
}
