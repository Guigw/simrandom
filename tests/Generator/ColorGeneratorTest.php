<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\ColorGenerator;
use PHPUnit\Framework\TestCase;

class ColorGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $poss = ['vert', 'blanc', 'rouge'];
        $generator = new ColorGenerator($poss);
        $result = $generator->getRandom();
        $this->assertTrue(in_array($result, $poss));
    }
}
