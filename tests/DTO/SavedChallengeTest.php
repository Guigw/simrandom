<?php

namespace Yrial\Simrandom\Tests\DTO;

use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\DTO\SavedChallenge;

class SavedChallengeTest extends TestCase
{
    use ProphecyTrait;

    public function testSetId()
    {
        $data = new SavedChallenge();
        $this->assertEquals(42, $data->setId(42)->getId());
    }

    public function testSetRandomizers()
    {
        $data = new SavedChallenge();
        $expected = ['riri', 'fifi', 'loulou'];
        $this->assertEquals($expected, $data->setRandomizers($expected)->getRandomizers());
    }

    public function testSetName()
    {
        $data = new SavedChallenge();
        $this->assertEquals(42, $data->setName(42)->getName());
    }

    public function testJsonSerialize()
    {
        $data = new SavedChallenge();
        $mockedRandom = array_map([$this, "getMock"], [1, 2, 3]);
        $data->setId(42)
            ->setName('coucou')
            ->setRandomizers($mockedRandom);

        $expected = [
            'id' => 42,
            'name' => 'coucou',
            'count' => count($mockedRandom),
            'randomizers' => [1, 2, 3]
        ];
        $this->assertEquals($expected, $data->jsonSerialize());
    }

    public function getMock($item): object
    {
        $mock = $this->prophesize(JsonSerializable::class);
        $mock->jsonSerialize()
            ->shouldBeCalledOnce()
            ->willReturn($item);
        return $mock->reveal();
    }
}
