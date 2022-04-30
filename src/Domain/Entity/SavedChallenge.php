<?php

namespace Yrial\Simrandom\Domain\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

class SavedChallenge
{

    private ?string $id;

    private Collection $results;

    private ?DateTimeInterface $sharingDate;

    private ?string $name;

    #[Pure]
    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(RandomizerResult $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setSavedChallenge($this);
        }

        return $this;
    }

    public function removeResult(RandomizerResult $result): self
    {
        if ($this->results->removeElement($result) && $result->getSavedChallenge() === $this) {
            // set the owning side to null (unless already changed)
            $result->setSavedChallenge(null);
        }

        return $this;
    }

    public function getSharingDate(): ?DateTimeInterface
    {
        return $this->sharingDate;
    }

    public function setSharingDate(): self
    {
        $this->sharingDate = new DateTimeImmutable();

        return $this;
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
}
