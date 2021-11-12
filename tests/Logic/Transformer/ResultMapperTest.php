<?php

namespace Yrial\Simrandom\Tests\Logic\Transformer;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\DTO\Result;
use Yrial\Simrandom\Entity\RandomizerResult;
use Yrial\Simrandom\Exception\BadOutputMapperException;
use Yrial\Simrandom\Logic\Transformer\ResultMapper;

class ResultMapperTest extends TestCase
{
    use ProphecyTrait;

    public function testGetEntity()
    {
        $this->assertEquals(RandomizerResult::class, ResultMapper::getEntity());
    }

    public function testGetDTO()
    {
        $this->assertEquals(Result::class, ResultMapper::getDTO());
    }

    public function testEntityToDTOException()
    {
        $this->expectException(BadOutputMapperException::class);
        $mapper = new ResultMapper();
        $mapper->EntityToDTO($this->prophesize(Result::class)->reveal());
    }

    /**
     * @throws BadOutputMapperException
     */
    public function testEntityToDTO()
    {
        $mockedEntity = $this->prophesize(RandomizerResult::class);
        $mockedEntity->getId()->shouldBeCalledOnce()->willReturn(42);
        $mockedEntity->getName()->shouldBeCalledOnce()->willReturn('huile');
        $mockedEntity->getResult()->shouldBeCalledOnce()->willReturn('de coco');
        $mapper = new ResultMapper();
        /** @var Result $result */
        $result = $mapper->EntityToDTO($mockedEntity->reveal());
        $this->assertInstanceOf(JsonSerializable::class, $result);
        $this->assertEquals(42, $result->getId());
        $this->assertEquals('huile', $result->getTitle());
        $this->assertEquals('de coco', $result->getResult());
        $this->assertNull($result->getRequired());
    }
}
