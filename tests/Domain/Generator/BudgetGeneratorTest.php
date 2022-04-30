<?php

namespace Yrial\Simrandom\Tests\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\BudgetGenerator;

class BudgetGeneratorTest extends TestCase
{
    public function testItExists()
    {
        $this->assertInstanceOf(BudgetGenerator::class, new BudgetGenerator());
    }

    public function testResult()
    {
        $generator = new BudgetGenerator();
        $conf = ['min' => 3, 'max' => 15];
        $generator->configure($conf);
        $result = $generator->getRandom();
        $this->assertCount(1, $result);
        $this->assertGreaterThanOrEqual(3, $result[0]);
        $this->assertLessThanOrEqual(15, $result[0]);
    }

    public function testDependencies()
    {
        $generator = new BudgetGenerator();
        $this->assertNull($generator->getDependencies());
    }
}
