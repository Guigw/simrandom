<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\BuildingsGenerator;
use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Generator\StringGenerator;

class BuildingsGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $possibility = ['pipoupi', 'titouti', 'jijouji'];
        $generator = new BuildingsGenerator($possibility);
        $this->assertTrue(in_array($generator->getRandom(), $possibility));
    }
}
