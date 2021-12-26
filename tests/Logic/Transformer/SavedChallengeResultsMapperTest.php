<?php

namespace Yrial\Simrandom\Tests\Logic\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\DTO\SavedChallenge as SavedChallengeResults;
use Yrial\Simrandom\Entity\SavedChallenge;
use Yrial\Simrandom\Exception\BadOutputMapperException;
use Yrial\Simrandom\Logic\Transformer\ResultMapper;
use Yrial\Simrandom\Logic\Transformer\SavedChallengeResultsMapper;

class SavedChallengeResultsMapperTest extends TestCase
{
    use ProphecyTrait;

    public function testGetEntity()
    {
        $this->assertEquals(SavedChallenge::class, SavedChallengeResultsMapper::getEntity());
    }

    /**
     * @throws BadOutputMapperException
     */
    public function testEntityToDTOException()
    {
        $mockedMapper = $this->prophesize(ResultMapper::class);
        $response = array_map(function ($item) {
            return $this->prophesize(JsonSerializable::class)->reveal();
        }, ['riri', 'fifi', 'loulou']);
        $mockedMapper->EntityToDTO(Argument::is(1))->shouldBeCalledOnce()->willReturn($response[0]);
        $mockedMapper->EntityToDTO(Argument::is(2))->shouldBeCalledOnce()->willReturn($response[1]);
        $mockedMapper->EntityToDTO(Argument::is(3))->shouldBeCalledOnce()->willReturn($response[2]);
        $mapper = new SavedChallengeResultsMapper($mockedMapper->reveal());
        $mockedEntity = $this->prophesize(SavedChallenge::class);
        $mockedEntity->getId()->shouldBeCalledOnce()->willReturn(42);
        $mockedEntity->getName()->shouldBeCalledOnce()->willReturn('recipes');
        $mockedEntity->getResults()->shouldBeCalledOnce()->willReturn(new ArrayCollection([1, 2, 3]));
        /** @var SavedChallengeResults $result */
        $result = $mapper->EntityToDTO($mockedEntity->reveal());
        $this->assertInstanceOf(JsonSerializable::class, $result);
        $this->assertEquals(42, $result->getId());
        $this->assertEquals('recipes', $result->getName());
        $this->assertCount(3, $result->getRandomizers());
    }

    public function testEntityToDTO()
    {
        $this->expectException(BadOutputMapperException::class);
        $mockedMapper = $this->prophesize(ResultMapper::class);
        $mapper = new SavedChallengeResultsMapper($mockedMapper->reveal());
        $mapper->EntityToDTO($this->prophesize(SavedChallengeResults::class)->reveal());
    }

    public function testGetDTO()
    {
        $this->assertEquals(SavedChallengeResults::class, SavedChallengeResultsMapper::getDTO());
    }
}
