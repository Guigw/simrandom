<?php

namespace Yrial\Simrandom\Tests\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\ColorsGenerator;
use Yrial\Simrandom\Domain\Generator\Generators;

class ColorsGeneratorTest extends TestCase
{

    public function testGetDependencies()
    {
        $generator = new ColorsGenerator();
        $deps = $generator->getDependencies();
        $this->assertCount(1, $deps);
        $this->assertEquals([Generators::Rooms->value], $deps);
    }

    public function testItExists()
    {
        $this->assertInstanceOf(ColorsGenerator::class, new ColorsGenerator());
    }

    public function testResult()
    {
        $generator = new ColorsGenerator();
        $conf = [['name' => 'bleu', 'weight' => 3], ['name' => 'red', 'weight' => 5]];
        $generator->configure($conf);
        $result = $generator->getRandom(2);
        $this->assertCount(2, $result);
        $this->assertContains($result[0], ['bleu', 'red']);
        $this->assertContains($result[1], ['bleu', 'red']);
    }
}
