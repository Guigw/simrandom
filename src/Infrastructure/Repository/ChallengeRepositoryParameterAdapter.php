<?php

namespace Yrial\Simrandom\Infrastructure\Repository;

use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Challenge;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;

class ChallengeRepositoryParameterAdapter implements ChallengeRepositoryInterface
{

    public function __construct(
        private readonly array $challenges
    )
    {
    }

    /**
     * @return Challenge[]
     */
    public function get(): array
    {
        return array_map([$this, 'hydrateChallenge'], $this->challenges);
    }

    /**
     * @param int $id
     * @return Challenge
     * @throws ChallengeNotFoundException
     */
    public function find(int $id): Challenge
    {
        $rawChallenge = array_filter($this->challenges, function ($challenge) use ($id) {
            return $challenge['id'] == $id;
        });
        if (empty($rawChallenge)) {
            throw new ChallengeNotFoundException();
        }
        return $this->hydrateChallenge($rawChallenge[0]);
    }

    private function hydrateChallenge($challenge): Challenge
    {
        return new Challenge(
            $challenge['id'],
            $challenge['name'],
            ...array_map(function ($rando) {
            return new Randomizer($rando);
        }, $challenge['randomizers']));
    }
}
