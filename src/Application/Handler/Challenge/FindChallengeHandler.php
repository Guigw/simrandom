<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Dto\Challenge\ChallengeDto;
use Yrial\Simrandom\Application\Query\FindChallengeQuery;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class FindChallengeHandler implements HandlerInterface
{
    public function handle(FindChallengeQuery $command, Challenge $result): ChallengeDto
    {
        return new ChallengeDto(
            $result->getId(),
            $result->getName(),
            $result->getRandomizers()
        );
    }
}

