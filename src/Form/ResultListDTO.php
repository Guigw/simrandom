<?php

namespace Yrial\Simrandom\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class ResultListDTO
{
    /**
     * @var ArrayCollection
     * @Assert\Count(
     *     min = 1,
     *     minMessage = "You must specify at least one result id"
     * )
     */
    protected $resultList = [];

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $name;

    public function __construct()
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
    public function setResultList($resultList): void
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