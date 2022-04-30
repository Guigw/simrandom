<?php

namespace Yrial\Simrandom\Domain\Dto;

use JetBrains\PhpStorm\ArrayShape;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class DetailChallengeResponseDto implements \JsonSerializable
{
    private int $id;
    private string $name;
    private Randomizers $randomizers;

    /**
     * @param int $id
     * @param string $name
     * @param Randomizers $randomizers
     */
    public function __construct(int $id, string $name, Randomizers $randomizers)
    {
        $this->id = $id;
        $this->name = $name;
        $this->randomizers = $randomizers;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'randomizers' => "array"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'randomizers' => array_map(function (Randomizer $rando) {
                return $rando->getName();
            }, iterator_to_array($this->randomizers->getIterator())),
        ];
    }


}