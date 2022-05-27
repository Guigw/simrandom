<?php

namespace Yrial\Simrandom\Domain\Entity;

use DateTimeInterface;
use Yrial\Simrandom\Domain\Exception\EmptyResultException;

class RandomizerResult
{
    public const IMPLODE_SEPARATOR = ",";

    private ?int $id;

    private ?string $name;

    private ?string $result;

    private ?DateTimeInterface $rollingDate;

    private ?SavedChallenge $savedChallenge;

    public function __construct(?DateTimeInterface $rollingDate = null)
    {
        if ($rollingDate) {
            $this->setRollingDate($rollingDate);
        }
    }


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

    private function getResult(): ?string
    {
        return $this->result;
    }

    public function getResults(): array
    {
        if (!empty($this->result)) {
            return explode(self::IMPLODE_SEPARATOR, $this->result);
        }
        return [];
    }

    private function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @param array $results
     * @return $this
     * @throws EmptyResultException
     */
    public function pushResults(array $results): self
    {
        if (!empty($results)) {
            $this->result = implode(self::IMPLODE_SEPARATOR, $results);
        } else {
            throw new EmptyResultException($this->name ?? '');
        }
        return $this;
    }

    public function getRollingDate(): ?DateTimeInterface
    {
        return $this->rollingDate;
    }

    public function setRollingDate(DateTimeInterface $date): self
    {
        $this->rollingDate = $date;

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
