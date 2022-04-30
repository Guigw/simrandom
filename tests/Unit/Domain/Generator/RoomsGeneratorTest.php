<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\RoomsGenerator;

class RoomsGeneratorTest extends TestCase
{
    public function testItExists()
    {
        $this->assertInstanceOf(RoomsGenerator::class, new RoomsGenerator());
    }

    public function testResult()
    {
        $generator = new RoomsGenerator();
        $conf = ['min' => 3, 'max' => 15];
        $generator->configure($conf);
        $result = $generator->getRandom();
        $this->assertCount(1, $result);
        $this->assertGreaterThanOrEqual(3, $result[0]);
        $this->assertLessThanOrEqual(15, $result[0]);
    }

    public function testDependencies()
    {
        $generator = new RoomsGenerator();
        $this->assertNull($generator->getDependencies());
    }
}
