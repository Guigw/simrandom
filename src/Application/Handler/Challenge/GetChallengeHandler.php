<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Dto\Challenge\ChallengeDto;
use Yrial\Simrandom\Application\Query\GetChallengeQuery;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class GetChallengeHandler implements HandlerInterface
{
    public function handle(GetChallengeQuery $command, array $results): array
    {
        return array_map(function (Challenge $challenge) {
            return new ChallengeDto($challenge->getId(), $challenge->getName(), $challenge->getRandomizers());
        }, $results);
    }
}
