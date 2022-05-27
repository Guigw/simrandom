<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\JsonListChallengeCommand;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class JsonChallengeListHandler implements HandlerInterface
{
    /**
     * @param JsonListChallengeCommand $command
     * @param Challenge[] $results
     * @return ListChallengeResponseDto[]
     */
    public function handle(JsonListChallengeCommand $command, array $results): array
    {
        return array_map(function (Challenge $challenge) {
            return new ListChallengeResponseDto($challenge->getId(), $challenge->getName(), count($challenge->getRandomizers()));
        }, $results);
    }
}