<?php

namespace Yrial\Simrandom\Application\Handler\Challenge;

use Yrial\Simrandom\Application\Contract\HandlerInterface;
use Yrial\Simrandom\Application\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\JsonDetailChallengeCommand;
use Yrial\Simrandom\Domain\ValueObject\Challenge;

class JsonChallengeDetailHandler implements HandlerInterface
{
    public function handle(JsonDetailChallengeCommand $command, Challenge $result): DetailChallengeResponseDto
    {
        return new DetailChallengeResponseDto(
            $result->getId(),
            $result->getName(),
            $result->getRandomizers()
        );
    }
}