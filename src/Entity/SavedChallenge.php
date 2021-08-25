<?php

namespace Yrial\Simrandom\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Yrial\Simrandom\Repository\SavedChallengeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=SavedChallengeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SavedChallenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=RandomizerResult::class, mappedBy="savedChallenge")
     */
    private $results;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $sharingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection|RandomizerResult[]
     */
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
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getSavedChallenge() === $this) {
                $result->setSavedChallenge(null);
            }
        }

        return $this;
    }

    public function getSharingDate(): ? \DateTimeInterface
    {
        return $this->sharingDate;
    }

    /**
     * @ORM\PrePersist
     * @return $this
     */
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
