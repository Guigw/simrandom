<?php

namespace Yrial\Simrandom\Domain\ValueObject;

class Challenge
{
    private int $id;
    private string $name;
    private Randomizers $randomizers;

    /**
     * @param int $id
     * @param string $name
     * @param Randomizer[] $randomizers
     */
    public function __construct(int $id, string $name, Randomizer ...$randomizers)
    {
        $this->id = $id;
        $this->name = $name;
        $this->randomizers = new Randomizers(...$randomizers);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Randomizers
     */
    public function getRandomizers(): Randomizers
    {
        return $this->randomizers;
    }
}