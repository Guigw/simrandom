<?php

namespace Yrial\Simrandom\Tests\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\BuildingGenerator;

class BuildingGeneratorTest extends TestCase
{
    public function testItExists()
    {
        $this->assertInstanceOf(BuildingGenerator::class, new BuildingGenerator());
    }

    public function testDependencies()
    {
        $generator = new BuildingGenerator();
        $this->assertNull($generator->getDependencies());
    }

    public function testResult()
    {
        $generator = new BuildingGenerator();
        $conf = ['min', 'max'];
        $generator->configure($conf);
        $result = $generator->getRandom();
        $this->assertCount(1, $result);
        $this->assertContains($result[0], $conf);
    }
}
