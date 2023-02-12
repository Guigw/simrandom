<?php

namespace Yrial\Simrandom\Domain\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

class ChallengeTry
{

    private ?string $id;

    private Collection $draws;

    private ?DateTimeInterface $sharingDate;

    private ?string $name;

    #[Pure]
    public function __construct(?DateTimeInterface $sharingDate = null)
    {
        $this->draws = new ArrayCollection();
        if ($sharingDate) {
            $this->sharingDate = $sharingDate;
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDraws(): Collection
    {
        return $this->draws;
    }

    public function addDraw(Draw $result): self
    {
        if (!$this->draws->contains($result)) {
            $this->draws[] = $result;
            $result->setTry($this);
        }

        return $this;
    }

    public function removeDraw(Draw $result): self
    {
        if ($this->draws->removeElement($result) && $result->getTry() === $this) {
            // set the owning side to null (unless already changed)
            $result->setTry(null);
        }

        return $this;
    }

    public function getSharingDate(): ?DateTimeInterface
    {
        return $this->sharingDate;
    }

    public function setSharingDate(DateTimeInterface $dateTime): self
    {
        $this->sharingDate = $dateTime;

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
