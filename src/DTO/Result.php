<?php

namespace Yrial\Simrandom\DTO;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Result implements JsonSerializable
{

    private ?int $id = null;

    private ?string $title;

    private ?string $result;

    private ?string $required = null;

    #[ArrayShape(['id' => "int", 'title' => "null|string", 'result' => "null|string"])]
    public function jsonSerialize(): array
    {
        $return = [
            'title' => $this->title,
            'result' => $this->result
        ];
        if ($this->id) {
            $return['id'] = $this->id;
        }
        if ($this->required) {
            $return['required'] = $this->required;
        }

        return $return;
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

    /**
     * @return string|null
     */
    public function getRequired(): ?string
    {
        return $this->required;
    }

    /**
     * @param string|null $required
     * @return Result
     */
    public function setRequired(?string $required): Result
    {
        $this->required = $required;
        return $this;
    }

}