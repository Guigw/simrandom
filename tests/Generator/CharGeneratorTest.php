<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\CharGenerator;
use PHPUnit\Framework\TestCase;

class CharGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $generator = new CharGenerator('A', 'T');
        $result = $generator->getRandom();
        $this->assertLessThanOrEqual("T", $result);
        $this->assertGreaterThanOrEqual("A", $result);
    }
}
