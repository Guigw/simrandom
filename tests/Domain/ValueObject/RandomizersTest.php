<?php

namespace Yrial\Simrandom\Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class RandomizersTest extends TestCase
{

    public function testItExists()
    {
        $randomizers = new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou'));
        $this->assertInstanceOf(\ArrayIterator::class, $randomizers->getIterator());
        $this->assertEquals(3, $randomizers->count());
    }
}
