<?php

namespace Yrial\Simrandom\Domain\Dto;

use JetBrains\PhpStorm\ArrayShape;
use Yrial\Simrandom\Domain\Contract\Generator\ChaosGenerator;

class ResultResponseDto implements \JsonSerializable
{
    private const IMPLODE_SEPARATOR = ", ";
    public readonly string $title;
    public readonly array $results;
    public readonly ?array $required;
    private ?int $id;

    /**
     * @param string $title
     * @param string[] $results
     * @param ?ChaosGenerator[] $required
     * @param int|null $id
     */
    public function __construct(string $title, array $results, ?array $required = null, int $id = null)
    {
        $this->title = $title;
        $this->results = $results;
        $this->required = $required;
        $this->id = $id;
    }

    /**
     * @return array
     */
    #[ArrayShape(['title' => "string", 'result' => "string", 'required' => "string", 'id' => "integer"])]
    public function jsonSerialize(): array
    {
        $return = [
            'title' => $this->title,
            'result' => self::arrayParamsToString($this->results),
        ];

        if ($this->required) {
            $return['required'] = self::arrayParamsToString($this->required);
        }

        if ($this->id) {
            $return['id'] = $this->id;
        }

        return $return;
    }

    public static function arrayParamsToString(array $value): string
    {
        return implode(self::IMPLODE_SEPARATOR, $value);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ResultResponseDto
     */
    public function setId(int $id): ResultResponseDto
    {
        $this->id = $id;
        return $this;
    }
}