<?php

namespace Yrial\Simrandom\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Yrial\Simrandom\Repository\RandomizerResultRepository;

#[ORM\Entity(repositoryClass: RandomizerResultRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RandomizerResult
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 1024)]
    private ?string $result;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeInterface $rollingDate;

    #[ORM\ManyToOne(targetEntity: SavedChallenge::class, inversedBy: 'results')]
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

    #[ORM\PrePersist]
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
