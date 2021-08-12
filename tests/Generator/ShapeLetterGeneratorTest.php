<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\ShapeLetterGenerator;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Generator\StringGenerator;

class ShapeLetterGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $params = ['start' => 'A', 'end' => 'G'];
        $generator = new ShapeLetterGenerator($params);
        $result = $generator->getRandom();
        $this->assertLessThanOrEqual("G", $result);
        $this->assertGreaterThanOrEqual("A", $result);
    }
}
