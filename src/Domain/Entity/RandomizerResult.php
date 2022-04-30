<?php

namespace Yrial\Simrandom\Domain\Entity;

use DateTimeImmutable;
use DateTimeInterface;

class RandomizerResult
{
    private ?int $id;

    private ?string $name;

    private ?string $result;

    private ?DateTimeInterface $rollingDate;

    private ?SavedChallenge $savedChallenge;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getRollingDate(): ?DateTimeInterface
    {
        return $this->rollingDate;
    }

    public function setRollingDate(): self
    {
        $this->rollingDate = new DateTimeImmutable();

        return $this;
    }

    public function getSavedChallenge(): ?SavedChallenge
    {
        return $this->savedChallenge;
    }

    public function setSavedChallenge(?SavedChallenge $savedChallenge): self
    {
        $this->savedChallenge = $savedChallenge;

        return $this;
    }
}
