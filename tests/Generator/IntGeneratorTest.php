<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\IntGenerator;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Generator\RoomsGenerator;

class IntGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $generator = new IntGenerator(100, 1000);
        $result = $generator->getRandom();
        $this->assertGreaterThanOrEqual(100, $result);
        $this->assertLessThanOrEqual(1000, $result);
    }
}
