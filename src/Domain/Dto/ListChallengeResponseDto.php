<?php

namespace Yrial\Simrandom\Domain\Dto;

use JetBrains\PhpStorm\ArrayShape;

class ListChallengeResponseDto implements \JsonSerializable
{
    private int $id;
    private string $name;
    private int $count;

    /**
     * @param int $id
     * @param string $name
     * @param int $count
     */
    public function __construct(int $id, string $name, int $count)
    {
        $this->id = $id;
        $this->name = $name;
        $this->count = $count;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string", 'count' => "int"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'count' => $this->count,
        ];
    }


}