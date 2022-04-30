<?php

namespace Yrial\Simrandom\Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;

class RandomizerTest extends TestCase
{

    public function testItExists()
    {
        $rando = new Randomizer('pouet');
        $this->assertEquals('pouet', $rando->getName());
    }
}
