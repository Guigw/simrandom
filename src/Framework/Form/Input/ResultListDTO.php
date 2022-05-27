<?php

namespace Yrial\Simrandom\Framework\Form\Input;

use Doctrine\Common\Collections\ArrayCollection;

class ResultListDTO
{
    protected ArrayCollection $resultList;
    /**
     * @var string
     */
    protected string $name;

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