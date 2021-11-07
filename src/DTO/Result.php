<?php

namespace Yrial\Simrandom\DTO;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Result implements JsonSerializable
{

    private int $id;

    private ?string $title;

    private ?string $result;

    #[ArrayShape(['id' => "int", 'title' => "null|string", 'result' => "null|string"])]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'result' => $this->result
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Result
     */
    public function setId(int $id): Result
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Result
     */
    public function setTitle(?string $title): Result
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * @param string|null $result
     * @return Result
     */
    public function setResult(?string $result): Result
    {
        $this->result = $result;
        return $this;
    }

}