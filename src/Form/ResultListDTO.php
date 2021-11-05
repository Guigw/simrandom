<?php

namespace Yrial\Simrandom\Form;

use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

class ResultListDTO
{

    #[Assert\Count(min: 1, minMessage: 'You must specify at least one result id')]
    protected ArrayCollection $resultList;

    /**
     * @var string
     */
    #[Assert\NotBlank]
    protected string $name;

    #[Pure] public function __construct()
    {
        $this->resultList = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getResultList(): ArrayCollection
    {
        return $this->resultList;
    }

    /**
     * @param mixed $resultList
     */
    public function setResultList(mixed $resultList): void
    {
        $this->resultList = $resultList;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}