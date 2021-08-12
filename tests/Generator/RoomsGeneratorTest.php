<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\RoomsGenerator;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Generator\ShapeLetterGenerator;

class RoomsGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $params = ['min' => 1, 'max' => 10];
        $generator = new RoomsGenerator($params);
        $result = $generator->getRandom();
        $this->assertGreaterThanOrEqual(1, $result);
        $this->assertLessThanOrEqual(10, $result);
    }
}
