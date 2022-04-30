<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Challenge;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class ChallengeTest extends TestCase
{

    public function testItExits()
    {
        $challenge = new Challenge(4, 'name', new  Randomizer('random'));
        $this->assertEquals(4, $challenge->getId());
        $this->assertEquals('name', $challenge->getName());
        $this->assertInstanceOf(Randomizers::class, $challenge->getRandomizers());
    }
}
