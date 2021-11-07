<?php

namespace Yrial\Simrandom\DTO;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class SavedChallenge implements JsonSerializable
{
    private string $id;

    private ?string $name;

    private array $randomizers;

    #[ArrayShape(['id' => "string", 'name' => "null|string", 'count' => "int", 'randomizers' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'count' => count($this->randomizers),
            'randomizers' => array_map(function (JsonSerializable $randomizer) {
                return $randomizer->jsonSerialize();
            }, $this->randomizers)
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SavedChallenge
     */
    public function setId(string $id): SavedChallenge
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SavedChallenge
     */
    public function setName(?string $name): SavedChallenge
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getRandomizers(): array
    {
        return $this->randomizers;
    }

    /**
     * @param array $randomizers
     * @return SavedChallenge
     */
    public function setRandomizers(array $randomizers): SavedChallenge
    {
        $this->randomizers = $randomizers;
        return $this;
    }
}