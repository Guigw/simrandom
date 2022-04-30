<?php

namespace Yrial\Simrandom\Domain\Dto;

use JetBrains\PhpStorm\ArrayShape;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SavedChallengeDto implements \JsonSerializable
{
    private string $id;
    private string $name;
    private array $results = [];

    public function __construct(SavedChallenge $challenge)
    {
        $this->checkChallengeId($challenge);
        $this->name = $challenge->getName();
        /** @var RandomizerResult $result */
        foreach ($challenge->getResults() as $result) {
            $this->results[] = new ResultResponseDto($result->getName(), [$result->getResult()], null, $result->getId());
        }
    }

    private function checkChallengeId(SavedChallenge $challenge): void
    {
        $rp = new \ReflectionProperty(SavedChallenge::class, 'id');
        if ($rp->isInitialized($challenge)) {
            $this->id = $challenge->getId();
        } else {
            $this->id = '';
        }
    }

    /**
     * @return mixed
     */
    #[ArrayShape(['id' => "null|string", 'name' => "null|string", 'count' => "int", 'randomizers' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'count' => count($this->results),
            'randomizers' => array_map(function (\JsonSerializable $randomizer) {
                return $randomizer->jsonSerialize();
            }, $this->results)
        ];
    }

}