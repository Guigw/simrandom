<?php

namespace Yrial\Simrandom\Tests\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\ShapeGenerator;

class ShapeGeneratorTest extends TestCase
{

    public function testItExists()
    {
        $this->assertInstanceOf(ShapeGenerator::class, new ShapeGenerator());
    }

    public function testResult()
    {
        $generator = new ShapeGenerator();
        $conf = ['start' => 'A', 'end' => 'Z'];
        $generator->configure($conf);
        $result = $generator->getRandom();
        $this->assertCount(1, $result);
        $this->assertGreaterThanOrEqual('A', $result[0]);
        $this->assertLessThanOrEqual('Z', $result[0]);
    }

    public function testDependencies()
    {
        $generator = new ShapeGenerator();
        $this->assertNull($generator->getDependencies());
    }
}
