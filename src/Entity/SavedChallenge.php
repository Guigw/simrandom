<?php

namespace Yrial\Simrandom\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Yrial\Simrandom\Repository\SavedChallengeRepository;

#[ORM\Entity(repositoryClass: SavedChallengeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SavedChallenge
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id;


    #[ORM\OneToMany(mappedBy: 'savedChallenge', targetEntity: RandomizerResult::class)]
    private Collection $results;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $sharingDate;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[Pure] public function __construct()
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

    public function getSharingDate(): ?\DateTimeInterface
    {
        return $this->sharingDate;
    }

    #[ORM\PrePersist]
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
