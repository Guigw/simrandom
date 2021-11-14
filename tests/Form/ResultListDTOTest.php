<?php

namespace Yrial\Simrandom\Tests\Form;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Form\ResultListDTO;

class ResultListDTOTest extends TestCase
{

    public function test__construct()
    {
        $dto = new ResultListDTO();
        $this->assertInstanceOf(ArrayCollection::class, $dto->getResultList());
    }

    public function testSetName()
    {
        $dto = new ResultListDTO();
        $dto->setName('coucou');
        $this->assertEquals('coucou', $dto->getName());
    }

    public function testSetResultList()
    {
        $dto = new ResultListDTO();
        $expected = new ArrayCollection(['la banboche']);
        $dto->setResultList($expected);
        $this->assertEquals($expected, $dto->getResultList());
    }
}